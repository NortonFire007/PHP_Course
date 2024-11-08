import { useState, useEffect } from 'react';
import { getCities, getWarehouses, createOrder } from './api';

function OrderForm() {
  const [orderNumber, setOrderNumber] = useState('');
  const [weight, setWeight] = useState('');
  const [cityInput, setCityInput] = useState('');
  const [cities, setCities] = useState([]);
  const [selectedCityRef, setSelectedCityRef] = useState('');
  const [deliveryType, setDeliveryType] = useState('');
  const [warehouses, setWarehouses] = useState([]);
  const [selectedWarehouseRef, setSelectedWarehouseRef] = useState('');
  const [isLoadingCities, setIsLoadingCities] = useState(false);
  const [isLoadingWarehouses, setIsLoadingWarehouses] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    const cachedData = localStorage.getItem('citiesCache');
    if (cachedData) {
      setCities(JSON.parse(cachedData));
    }
  }, []);

  useEffect(() => {
    const interval = setInterval(() => {
      localStorage.removeItem('citiesCache');
    }, 24 * 60 * 60 * 1000);

    return () => clearInterval(interval);
  }, []);

  const handleCityInputChange = async (e) => {
    const value = e.target.value;
    setCityInput(value);
    setSelectedCityRef('');
    setWarehouses([]);
    setDeliveryType('');

    if (value.length >= 3) {
      setIsLoadingCities(true);
      const citiesData = await getCities(value);
      setIsLoadingCities(false);

      if (citiesData.success) {
        setCities(citiesData.data);
        localStorage.setItem('citiesCache', JSON.stringify(citiesData.data));
      } else {
        setError(citiesData.message || 'Error fetching cities.');
      }
    } else {
      setCities([]);
    }
  };

  const handleCitySelection = (e) => {
    const selectedCity = cities.find(
      (city) => city.Description === e.target.value
    );
    if (selectedCity) {
      setSelectedCityRef(selectedCity.Ref);
      setCityInput(selectedCity.Description);
      setWarehouses([]);
      setDeliveryType('');
    }
  };

  const handleDeliveryTypeChange = async (e) => {
    const type = e.target.value;
    setDeliveryType(type);
    setSelectedWarehouseRef('');

    if (selectedCityRef && type) {
      const typeRef =
        type === 'postamat'
          ? 'f9316480-5f2d-425d-bc2c-ac7cd29decf0'
          : '841339c7-591a-42e2-8233-7a0a00f0ed6f';
      setIsLoadingWarehouses(true);
      const warehousesData = await getWarehouses(
        selectedCityRef,
        typeRef,
        weight
      );
      setIsLoadingWarehouses(false);

      if (warehousesData.success) {
        setWarehouses(warehousesData.data);
      } else {
        setError(warehousesData.message || 'Error fetching warehouses.');
      }
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    if (!weight || !selectedCityRef || !deliveryType || !selectedWarehouseRef) {
      setError('Будь ласка, заповніть всі поля.');
      return;
    }

    const orderData = {
      weight: parseFloat(weight),
      city_ref: selectedCityRef,
      delivery_type: deliveryType,
      warehouse_ref: selectedWarehouseRef,
    };

    const response = await createOrder(orderData);

    if (response.success) {
      alert(`Замовлення створено успішно з номером: ${response.order_number}`);
      setOrderNumber(response.order_number);
      setWeight('');
      setCityInput('');
      setSelectedCityRef('');
      setDeliveryType('');
      setWarehouses([]);
      setSelectedWarehouseRef('');
    } else {
      setError(response.message || 'Помилка при створенні замовлення.');
    }
  };

  return (
    <div className="max-w-lg mx-auto p-6 bg-white rounded shadow-md">
      <h2 className="text-2xl font-bold mb-4">Створити замовлення</h2>
      {error && <div className="mb-4 text-red-500">{error}</div>}
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="block text-sm font-medium text-gray-700">
            Вага замовлення (кг)
          </label>
          <input
            type="number"
            step="0.01"
            value={weight}
            onChange={(e) => setWeight(e.target.value)}
            className="mt-1 block w-full border border-gray-300 rounded-md p-2"
            required
          />
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700">
            Назва міста
          </label>
          <input
            type="text"
            value={cityInput}
            onChange={handleCityInputChange}
            onBlur={handleCitySelection}
            list="cities-list"
            className="mt-1 block w-full border border-gray-300 rounded-md p-2"
            placeholder="Введіть назву міста"
            required
          />
          <datalist id="cities-list">
            {cities.map((city) => (
              <option key={city.Ref} value={city.Description} />
            ))}
          </datalist>
        </div>

        <div>
          <label className="block text-sm font-medium text-gray-700">
            Тип доставки
          </label>
          <select
            value={deliveryType}
            onChange={handleDeliveryTypeChange}
            className="mt-1 block w-full border border-gray-300 rounded-md p-2"
            required
          >
            <option value="">Виберіть тип доставки</option>
            <option value="postamat">Поштомат</option>
            <option value="branch">Відділення</option>
          </select>
        </div>

        {deliveryType && (
          <div>
            <label className="block text-sm font-medium text-gray-700">
              Відділення/Поштомат
            </label>
            {isLoadingWarehouses ? (
              <p className="text-gray-500">Завантаження відділень...</p>
            ) : warehouses.length > 0 ? (
              <select
                value={selectedWarehouseRef}
                onChange={(e) => setSelectedWarehouseRef(e.target.value)}
                className="mt-1 block w-full border border-gray-300 rounded-md p-2"
                required
              >
                <option value="">Виберіть відділення/поштомат</option>
                {warehouses.map((warehouse) => (
                  <option key={warehouse.Ref} value={warehouse.Ref}>
                    {warehouse.Description}
                  </option>
                ))}
              </select>
            ) : (
              <p className="text-gray-500">
                Немає доступних відділень для цього типу доставки та ваги.
              </p>
            )}
          </div>
        )}

        <button
          type="submit"
          className="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
        >
          Створити замовлення
        </button>
      </form>
      {orderNumber && (
        <div className="mt-4 p-4 bg-green-100 text-green-700 rounded">
          Ваш номер замовлення: <strong>{orderNumber}</strong>
        </div>
      )}
    </div>
  );
}

export default OrderForm;
