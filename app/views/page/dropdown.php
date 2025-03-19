<div class="dropdown">
    <a href="#" class="sidebar-link" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle fs-2"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="dropdownMenu">
        <!-- Nội dung sẽ được cập nhật bằng JavaScript -->
    </ul>
</div>




<script>
const role = "<?= isset($_SESSION['user']) ? $_SESSION['user']['role'] : '' ?>"; 
const dropdownMenu = document.getElementById("dropdownMenu");

if (role === "admin") {
    dropdownMenu.innerHTML = `
        <li>
            <a class="dropdown-item" href="<?= ROOT ?>admin/home">
                <i class="bi bi-person"></i> Chế độ quản lí
            </a>
        </li>
        <li>
            <a id="toggle-dark" class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-moon"></i> Giao diện tối/sáng
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-danger" href="<?= ROOT ?>auth/logout">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </li>
    `;
} else if (role === "customer") {
    dropdownMenu.innerHTML = `
        <li>
            <a class="dropdown-item" href="#">
                <i class="bi bi-person"></i> Tài khoản
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="bi bi-ticket-detailed"></i> Vé của tôi
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-moon"></i> Giao diện tối/sáng
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-danger" href="<?= ROOT ?>auth/logout">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </li>
    `;
} else {
    // Nếu chưa đăng nhập
    dropdownMenu.innerHTML = `
        <li>
            <a class="dropdown-item" href="<?= ROOT ?>auth/login">
                Đăng nhập
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item" href="<?= ROOT ?>auth/register">
                Đăng ký
            </a>
        </li>
    `;
}
</script>

