### **Find Similar Products Integration**

This project integrates a Python-based image processing service with YOLOv8 to detect and recommend visually similar products. The Python service processes product images and returns the most relevant categories, enabling Laravel to suggest similar items.

---

### **How It Works**

1. **Python API**:
   - Processes uploaded images using YOLOv8 to detect product categories.
   - Returns the detected category ID and name with the highest confidence.

2. **Laravel Integration**:
   - The `findSimilar` function in Laravel sends a POST request with the product image to the Python API.
   - The API response is used to retrieve and recommend visually similar products.

3. **Error Handling**:
   - Laravel gracefully handles API errors by logging issues and providing default recommendations.

---

### **Setup Instructions**

1. Clone and run the Python service:
   ```bash
   git clone https://github.com/your-repo/python_find_similar_products.git
   cd python_find_similar_products
   pip install -r requirements.txt
   python app.py
   ```

2. Ensure the Laravel project is configured to communicate with the Python API (`http://127.0.0.1:5000`).

---

This integration enhances product recommendations by leveraging advanced image detection with YOLOv8.
