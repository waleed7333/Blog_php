
<?php 
// v_blog/app/views/layout/alertMessage.php
?>

<?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div id="message-box" class="alert <?= isset($_SESSION['success']) ? 'alert-success' : 'alert-danger' ?> position-fixed top-10 start-50 translate-middle shadow-lg" style="z-index: 9999; padding: 20px; border-radius: 8px; font-size: 18px; font-weight: bold; width: 300px; text-align: center;">
        <?= $_SESSION['success'] ?? $_SESSION['error'] ?>
    </div>
<?php
    // حذف الرسالة بعد عرضها
    unset($_SESSION['success']);
    unset($_SESSION['error']);
endif; 
?>

<script>
    // إخفاء الرسالة بعد 2 ثانية ثم إزالتها
    setTimeout(() => {
        const messageBox = document.getElementById('message-box');
        if (messageBox) {
            messageBox.style.opacity = '0';
            setTimeout(() => messageBox.remove(), 1000); 
        }
    }, 3000);
</script>
