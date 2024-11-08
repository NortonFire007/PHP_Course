const BASE_URL = 'http://127.0.0.1:8080/Lab_8/backend/public/api.php';

export const getCities = async (findByString) => {
  try {
    const response = await fetch(
      `${BASE_URL}?action=getCities&FindByString=${encodeURIComponent(
        findByString
      )}`
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching cities:', error);
    return { success: false, message: 'Error fetching cities.' };
  }
};

export const getWarehouses = async (cityRef, typeRef, weight) => {
  try {
    const response = await fetch(
      `${BASE_URL}?action=getWarehouses&CityRef=${encodeURIComponent(
        cityRef
      )}&TypeOfWarehouseRef=${encodeURIComponent(
        typeRef
      )}&weight=${encodeURIComponent(weight)}`
    );
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching warehouses:', error);
    return { success: false, message: 'Error fetching warehouses.' };
  }
};

export const createOrder = async (orderData) => {
  try {
    const response = await fetch(`${BASE_URL}?action=createOrder`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(orderData),
    });
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error creating order:', error);
    return { success: false, message: 'Error creating order.' };
  }
};
