<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>



  <link rel="stylesheet" href="<?=DIST?>assets/compiled/css/app.css">
  <link rel="stylesheet" href="<?=DIST?>assets/compiled/css/app-dark.css">
  <link rel="stylesheet" href="<?=DIST?>assets/compiled/css/iconly.css">

  <link rel="stylesheet" href="<?=DIST?>assets/extensions/simple-datatables/style.css">


</head>

<body>
	<script src="<?=DIST?>assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'sidebar.php'; ?>
        <div id="main">
            <!-- Header -->
			<div class="page-heading">
                <header class="navbar mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                    <div class="logo fs-1">
                        <a href="<?=ROOT?>home">Move</a> |
                        <a href="<?=ROOT?>poster">Poster</a>
                    </div>

                    <?php include 'dropdown.php'; ?>
                </header>
            </div>
            <!-- Nội dung -->
            <div class="page-content">
                <!-- Bảng dữx liệu -->
                <div class="card">
                    <div class="card-header">
                        <div class="h3">Dữ liệu</div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>STT</th> <!-- Thêm cột STT -->
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày hết hạn</th>
                                    <th>Tiêu đề</th>
                                    <th>Tên tệp</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>

                                <script>
                                    const data = <?php echo json_encode($data); ?>;
                                    renderPosters(data.poster);
                                    function renderPosters(posters) {
                                        let tbody = document.querySelector("#table1 tbody");
                                        tbody.innerHTML = ""; 

                                        posters.forEach((poster, index) => {
                                            let fileName = poster.url.split('/').pop();
                                            let row = `<tr>
                                                <td class="col-1">${index + 1}</td> <!-- STT -->
                                                <td class="col-2">${poster.start_date}</td>
                                                <td class="col-2">${poster.expiration_date}</td>
                                                <td class="col-2">${poster.title}</td>
                                                <td class="col-2">${fileName}</td>
                                                <td class="col-2">
                                                <button type="none" class="btn 
                                                    ${poster.status === 'Coming' ? 'btn-warning' : 
                                                    poster.status === 'Showing' ? 'btn-primary' : 
                                                    poster.status === 'Ended' ? 'btn-danger' : 'btn-secondary'}" 
                                                    title="Status: ${poster.status || 'Unknown'}">
                                                    ${poster.status}
                                                </button>
                                                
                                                </td>
                                                <td class="col-1"><button class="btn btn-success" onclick="showPoster(${poster.id})">...</button></td>
                                                <td class="col-1">
                                                    <button class="btn btn-danger" onclick="deletePoster(${poster.id}, '${poster.url}')">
                                                        Xóa
                                                    </button>
                                                </td>
                                            </tr>`;
                                            tbody.innerHTML += row;
                                        });


                                    }
                                </script>
                                <script>
                                    function deletePoster(posterId, posterUrl) {
                                        if (confirm("Bạn có chắc chắn muốn xóa?")) {
                                            let form = document.createElement("form");
                                            form.method = "POST";
                                            form.action = "<?=ROOT?>poster/delete";

                                            let inputId = document.createElement("input");
                                            inputId.type = "hidden";
                                            inputId.name = "id";
                                            inputId.value = posterId;

                                            let inputUrl = document.createElement("input");
                                            inputUrl.type = "hidden";
                                            inputUrl.name = "url";
                                            inputUrl.value = posterUrl; // Thêm URL

                                            form.appendChild(inputId);
                                            form.appendChild(inputUrl);
                                            document.body.appendChild(form);
                                            form.submit();
                                        }
                                    }

                                    function showPoster(posterId) {
                                        let poster = data.poster.find(p => p.id == posterId);

                                        if (!poster) {
                                            alert("Không tìm thấy poster!");
                                            return;
                                        }
                                        document.getElementById("file").disabled = true;
                                        document.getElementById("file").value = ""; // Không thể set giá trị file, phải chọn lại
                                        document.getElementById("url").value = poster.url;
                                        document.getElementById("start_date").value = poster.start_date;
                                        document.getElementById("expiration_date").value = poster.expiration_date;
                                        document.getElementById("title").value = poster.title;
                                        document.getElementById("description").value = poster.description;
                                        document.getElementById("id").value = poster.id;
                                        
                                        const statusInput = document.getElementById("status");
                                        const statusBtn = document.getElementById("statusBtn");


                                        if (poster.status === "Coming") {
                                            statusBtn.className = "btn btn-warning";
                                            statusBtn.textContent = "Coming";
                                            statusInput.value = "Coming";
                                        } else if (poster.status === "Showing") {
                                            statusBtn.className = "btn btn-primary";
                                            statusBtn.textContent = "Showing";
                                            statusInput.value = "Showing";
                                        } else if (poster.status === "Ended") {
                                            statusBtn.className = "btn btn-danger";
                                            statusBtn.textContent = "Ended";
                                            statusInput.value = "Ended";
                                        }


                                        document.getElementById("display").scrollIntoView({ behavior: "smooth" });



                                    }

                                    
                                </script>
                            </tbody>
                        </table>
                       



                    </div>

                </div>

                <!-- Thêm poster -->
                <div class="card">
                    <div class="card-header">
                        <div class="h3">Cập nhật/ Thêm mới</div>
                    </div>
                    <div class="card-body">
                        <!-- Form -->
                        <form id="display" action="<?=ROOT?>poster/insert" method="post" enctype="multipart/form-data" class="border p-3 rounded">
                            <!-- Input ẩn -->
                            <input type="hidden" id="id" name="id" value="">

                            <div class="mb-3">
                                <label for="poster" class="form-label">Chọn ảnh poster</label>
                                <input type="file" id="file" name="file" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">
                                    URL (mặc định) <span style="color: red">*</span>
                                </label>
                                <input type="text" id="url" name="url" class="form-control" readonly required>

                                <script>
                                    document.getElementById("file").addEventListener("change", function(event) {
                                        let file = event.target.files[0];
                                        if (file) {
                                            document.getElementById("url").value = "<?=STORAGE?>app/main/posters/" + file.name;
                                        }
                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Ngày có hiệu lực <span style="color: red">*</span></label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">
                                    Ngày hết hiệu lực <span style="color: red">*</span>
                                    <span id="expiration_date_error" style="color: red;"></span>
                                </label>
                                <input type="date" id="expiration_date" name="expiration_date" class="form-control" required>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let today = new Date().toISOString().split("T")[0];
                                        let startDateInput = document.getElementById("start_date");
                                        let expirationDateInput = document.getElementById("expiration_date");
                                        let expirationDateError = document.getElementById("expiration_date_error");

                                        function validateExpirationDate() {
                                            if (expirationDateInput.value < startDateInput.value) {
                                                expirationDateError.textContent = "Ngày hết hiệu lực phải lớn hơn hoặc bằng ngày có hiệu lực: " + startDateInput.value;
                                            } else {
                                                expirationDateError.textContent = "";
                                            }
                                        }

                                        startDateInput.addEventListener("change", validateExpirationDate);
                                        expirationDateInput.addEventListener("change", validateExpirationDate);
                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <button type="button" id="statusBtn" class="btn btn-secondary">Unknown</button>
                                <input type="hidden" id="status" name="status">

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let today = new Date().toISOString().split("T")[0];
                                        let startDateInput = document.getElementById("start_date");
                                        let expirationDateInput = document.getElementById("expiration_date");
                                        let statusBtn = document.getElementById("statusBtn");
                                        let statusInput = document.getElementById("status");

                                        function updateStatus() {
                                            let start_date = startDateInput.value;
                                            let exp = expirationDateInput.value;

                                            if (!start_date || !exp) return;

                                            if (start_date > today) {
                                                statusBtn.className = "btn btn-warning";
                                                statusBtn.textContent = "Coming";
                                                statusInput.value = "Coming";
                                            } else if (start_date <= today && exp >= today) {
                                                statusBtn.className = "btn btn-primary";
                                                statusBtn.textContent = "Showing";
                                                statusInput.value = "Showing";
                                            } else if (exp < today) {
                                                statusBtn.className = "btn btn-danger";
                                                statusBtn.textContent = "Ended";
                                                statusInput.value = "Ended";
                                            }
                                        }

                                        if (startDateInput) startDateInput.addEventListener("change", updateStatus);
                                        if (expirationDateInput) expirationDateInput.addEventListener("change", updateStatus);
                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" id="title" name="title" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>

                            <div id="message" class="h-3">
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const data = <?php echo json_encode($data); ?>;
                                        const messageDiv = document.getElementById("message");

                                        if (data.error) {
                                            messageDiv.className = "alert alert-danger"; 
                                            messageDiv.textContent = data.error;
                                            messageDiv.style.display = "block";
                                            alert(data.error);
                                        } else if (data.success) {
                                            renderPosters(data.poster);
                                            messageDiv.className = "alert alert-success"; 
                                            messageDiv.textContent = data.success;
                                            messageDiv.style.display = "block";
                                            alert(data.success);
                                        } else {
                                            messageDiv.style.display = "none";
                                        }
                                    });
                                </script>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <button type="button" class="btn btn-danger" id="resetFormBtn">Hủy</button>
                            </div>

                            <script>
                                document.getElementById("resetFormBtn").addEventListener("click", function () {
                                    document.getElementById("display").reset();
                                    document.getElementById("url").value = "";
                                    document.getElementById("statusBtn").textContent = "Unknown"; 
                                    document.getElementById("statusBtn").className = "btn btn-secondary";
                                    document.getElementById("status").value = "";
                                    document.getElementById("id").value = "";
                                    document.getElementById("file").disabled = false;

                                     // Xóa thông báo thành công hoặc lỗi trong message div
                                    const messageDiv = document.getElementById("message");
                                    messageDiv.textContent = "";
                                    messageDiv.style.display = "none";

                                });

                                document.getElementById("display").addEventListener("submit", function(event) {
                                    if (confirm("Bạn có chắc chắn muốn lưu?")) {
                                        let idField = document.getElementById("id");
                                        if (idField.value.trim() !== "") {
                                            this.action = "<?=ROOT?>poster/update";
                                        } else {
                                            this.action = "<?=ROOT?>poster/insert";
                                        }
                                    }
                                    
                                });
                            </script>




                        </form>

                        <script>
                            
                        </script>
                    </div>
                        

                        

                        
                </div>




            </div>
            <!-- Footer -->
            <?php include 'footer.php'; ?>
        </div>
    </div>
    <script src="<?=DIST?>assets/static/js/components/dark.js"></script>
    <script src="<?=DIST?>assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?=DIST?>assets/compiled/js/app.js"></script>



	<!-- Need: Apexcharts -->
	<script src="<?=DIST?>assets/extensions/apexcharts/apexcharts.min.js"></script>
	<script src="<?=DIST?>assets/static/js/pages/dashboard.js"></script>





    <script src="<?=DIST?>assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="<?=DIST?>assets/static/js/pages/simple-datatables.js"></script>







</body>

</html>