// v_blog/public/js/main.js

// التأكد من تحميل المستند
document.addEventListener('DOMContentLoaded', function() {
    // معالجة النماذج
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    e.preventDefault();
                    alert('يرجى ملء جميع الحقول المطلوبة');
                }
            });
        });
    });

    // معاينة الصور قبل الرفع
    const imageInput = document.querySelector('input[type="file"]');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('يرجى اختيار ملف صورة صالح');
                    this.value = '';
                } else if (file.size > 5000000) { // 5MB
                    alert('حجم الصورة كبير جداً. الحد الأقصى هو 5 ميجابايت');
                    this.value = '';
                }
            }
        });
    }
});