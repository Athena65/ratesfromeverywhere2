# **RatesFromEverywhere2**

**RatesFromEverywhere2** is a platform that analyzes product images to detect visually similar products and collects product reviews from various e-commerce platforms. This project combines a Laravel-based web application with a Python-based image processing service integrated with YOLOv8.

---

## **Features**

- **Visual Product Analysis**: Analyzes uploaded product images using YOLOv8 and identifies relevant categories.
- **Product Review Aggregation**: Collects product reviews from various e-commerce platforms and provides a consolidated overview.
- **Similar Product Recommendations**: Recommends similar products based on analyzed images and aggregated reviews.

---

## **Architecture**

The general architecture of the system is as follows:

1. **User**: Uploads a product image.
2. **Laravel Application**: Receives the uploaded image and sends it to the Python API.
3. **Python API**: Analyzes the image using YOLOv8 and identifies the product category.
4. **Laravel Application**: Fetches product reviews from various e-commerce platforms based on the detected category and recommends similar products to the user.

---

## **Screenshots**
![Admin Panel Overview](https://github.com/user-attachments/assets/84e6996e-3a56-4d08-a7c0-9a329d4a3d99)
![Admin Panel Categories](https://github.com/user-attachments/assets/aa8cac3b-cdc5-49b5-97da-b9ab3d60a468)
![Admin Panel Products](https://github.com/user-attachments/assets/3afbb37f-b3e2-4886-a4c9-5080801f0612)
![Main Screen](https://github.com/user-attachments/assets/01dc0c3d-7107-4df2-98c4-cd6483ba2d23)
![Model Plane Product Request](https://github.com/user-attachments/assets/7c34873f-a49d-4899-89f5-49ba31272f5d)
![Request Add Product](https://github.com/user-attachments/assets/23d043f8-ffdb-4c97-93eb-6ff52f72cc84)
![Request Modal](https://github.com/user-attachments/assets/37d53ba0-94c4-4fbf-8577-472142ad36c7)
![Similar Products Found](https://github.com/user-attachments/assets/7178fe3f-716b-41da-8955-bb78912e1cf3)
![Product Details View](https://github.com/user-attachments/assets/18b26542-79fc-4cc9-b049-8f4157be6e79)
![Ratemodal-productadd](https://github.com/user-attachments/assets/615a93ec-431c-444c-850e-83a83b9ec6a5)

---

## **Setup and Installation**

### **1. Setting Up the Python Service**

- Clone the required repository and install dependencies:

  ```bash
  git clone https://github.com/Athena65/python_find_similar_products.git
  cd python_find_similar_products
  pip install -r requirements.txt
  ```

- Run the `app.py` file:

  ```bash
  python app.py
  ```

### **2. Setting Up the Laravel Application**

- Clone the required repository and install dependencies:

  ```bash
  git clone https://github.com/Athena65/ratesfromeverywhere2.git
  cd ratesfromeverywhere2
  composer install
  npm install
  ```

- Configure the `.env` file and run the application:

  ```bash
  cp .env.example .env
  php artisan key:generate
  php artisan serve
  ```

---

## **Usage**

1. **Image Upload**: The user uploads a product image through the interface.
2. **Image Analysis**: The Laravel application sends the image to the Python API and retrieves the product category.
3. **Review Aggregation**: Laravel collects product reviews from various e-commerce platforms based on the detected category.
4. **Similar Product Recommendations**: The user receives similar product recommendations and a consolidated review overview.

---

## **Contributing**

We welcome contributions! Please create a pull request or open an issue to contribute.
