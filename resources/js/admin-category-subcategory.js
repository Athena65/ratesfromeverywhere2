document.addEventListener('DOMContentLoaded', function () {
    // Sayfa yüklendiğinde seçili kategorilere göre alt kategorileri yükleyin
    loadSubcategoriesForSelectedCategories();
});

document.querySelectorAll('.category-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        loadSubcategoriesForSelectedCategories();
    });
});

function loadSubcategoriesForSelectedCategories() {
    const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked'))
        .map(cb => cb.value);

    // Alt kategoriler alanını temizle
    const subcategoryContainer = document.getElementById('subcategoryContainer');
    subcategoryContainer.innerHTML = '';

    if (selectedCategories.length === 0) {
        // Eğer hiçbir kategori seçilmemişse, alt kategori alanını boş bırakın
        return;
    }

    // Her seçili kategori için alt kategorileri al
    selectedCategories.forEach(categoryId => {
        fetch(`/admin/categories/${categoryId}/subcategories/${productId}`)
            .then(response => response.json())
            .then(data => {
                const categoryName = data.category_name;
                const subcategories = data.subcategories;
                const selectedSubcategories = data.selected_subcategories;

                if (subcategories.length === 0) {
                    // Eğer alt kategori yoksa, bilgilendirme mesajını göster
                    const noSubcategoryDiv = document.createElement('div');
                    noSubcategoryDiv.classList.add('col-12', 'mb-2');
                    noSubcategoryDiv.innerHTML = `No subcategories available for the category <strong>"${categoryName}"</strong>`;
                    subcategoryContainer.appendChild(noSubcategoryDiv);
                } else {
                    // Alt kategorileri ekle
                    subcategories.forEach(subcategory => {
                        const colDiv = document.createElement('div');
                        colDiv.classList.add('col-md-6', 'col-lg-4', 'mb-2');

                        const formCheckDiv = document.createElement('div');
                        formCheckDiv.classList.add('form-check');

                        const input = document.createElement('input');
                        input.type = 'checkbox';
                        input.className = 'form-check-input';
                        input.name = 'subcategories[]';
                        input.value = subcategory.id;
                        input.id = `subcategory${subcategory.id}`;

                        const label = document.createElement('label');
                        label.className = 'form-check-label';
                        label.htmlFor = `subcategory${subcategory.id}`;
                        label.textContent = subcategory.name;

                        // Eğer alt kategori daha önce seçilmişse, checkbox'ı seçili yap
                        if (selectedSubcategories.includes(subcategory.id)) {
                            input.checked = true;
                        }

                        formCheckDiv.appendChild(input);
                        formCheckDiv.appendChild(label);
                        colDiv.appendChild(formCheckDiv);
                        subcategoryContainer.appendChild(colDiv);
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching subcategories:", error);
            });
    });
}
