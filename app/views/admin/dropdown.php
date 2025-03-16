<div class="dropdown">
    <a href="#" class="sidebar-link" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle fs-2"></i>
    </a>

    <?php if ($user): ?>
        <!-- Nếu đã đăng nhập -->
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
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
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <i class="bi bi-moon"></i> Giao diện tối/sáng
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item text-danger" href="<?=ROOT?>auth/logout">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </li>
        </ul>
    <?php else: ?>
        <!-- Nếu chưa đăng nhập -->
        <div class="dropdown-menu dropdown-menu-end p-3">
        <li>
                <a class="dropdown-item" href="<?=ROOT?>auth/login">
                    Đăng nhập
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="<?=ROOT?>auth/register">
                    Đăng kí
                </a>
            </li>
        </div>
    <?php endif; ?>
</div>
