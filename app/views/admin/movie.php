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
                        <a href="<?=ROOT?>movie">Movie</a>
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
                                    <th>Trailer</th>
                                    <th>Tên tệp</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>

                                <script>
                                    const data = <?php echo json_encode($data); ?>;
                                    renderMovies(data.movie);
                                    function renderMovies(movies) {
                                        let tbody = document.querySelector("#table1 tbody");
                                        tbody.innerHTML = ""; 

                                        movies.forEach((movie, index) => {
                                            let fileName = movie.url.split('/').pop();
                                            let row = `<tr>
                                                <td class="col-1">${index + 1}</td> <!-- STT -->
                                                <td class="col-2">${movie.premiere_date}</td>
                                                <td class="col-2">${movie.expiration_date}</td>
                                                <td class="col-2">${movie.trailer}</td>
                                                <td class="col-2">${fileName}</td>
                                                <td class="col-2">
                                                <button type="none" class="btn 
                                                    ${movie.status === 'Coming' ? 'btn-warning' : 
                                                    movie.status === 'Showing' ? 'btn-primary' : 
                                                    movie.status === 'Ended' ? 'btn-danger' : 'btn-secondary'}" 
                                                    title="Status: ${movie.status || 'Unknown'}">
                                                    ${movie.status}
                                                </button>
                                                
                                                </td>
                                                <td class="col-1"><button class="btn btn-success" onclick="showMovie(${movie.id})">...</button></td>
                                                <td class="col-1">
                                                    <button class="btn btn-danger" onclick="deleteMovie(${movie.id}, '${movie.url}')">
                                                        Xóa
                                                    </button>
                                                </td>
                                            </tr>`;
                                            tbody.innerHTML += row;
                                        });


                                    }
                                </script>
                                <script>
                                    function deleteMovie(movieId, movieUrl) {
                                        if (confirm("Bạn có chắc chắn muốn xóa?")) {
                                            let form = document.createElement("form");
                                            form.method = "POST";
                                            form.action = "<?=ROOT?>movie/delete";

                                            let inputId = document.createElement("input");
                                            inputId.type = "hidden";
                                            inputId.name = "id";
                                            inputId.value = movieId;

                                            let inputUrl = document.createElement("input");
                                            inputUrl.type = "hidden";
                                            inputUrl.name = "url";
                                            inputUrl.value = movieUrl; // Thêm URL

                                            form.appendChild(inputId);
                                            form.appendChild(inputUrl);
                                            document.body.appendChild(form);
                                            form.submit();
                                        }
                                    }

                                    function showMovie(movieId) {
                                        // Tìm movie trong danh sách data.movie
                                        let movie = data.movie.find(p => p.id == movieId);

                                        // Kiểm tra nếu không tìm thấy movie
                                        if (!movie) {
                                            alert("Không tìm thấy movie!");
                                            return;
                                        }

                                        // Vô hiệu hóa trường file và reset giá trị
                                        document.getElementById("file").disabled = true;
                                        document.getElementById("file").value = ""; // Không thể set giá trị file, phải chọn lại

                                        // Cập nhật các trường cơ bản
                                        document.getElementById("url").value = movie.url || "";
                                        document.getElementById("premiere_date").value = movie.premiere_date || "";
                                        document.getElementById("expiration_date").value = movie.expiration_date || "";
                                        document.getElementById("title").value = movie.title || "";
                                        document.getElementById("description").value = movie.description || "";
                                        document.getElementById("id").value = movie.id || "";
                                        document.getElementById("category_code").value = movie.category_code || "";

                                        // Cập nhật các trường bổ sung
                                        document.getElementById("trailer").value = movie.trailer || "";
                                        document.getElementById("time").value = movie.time || "";
                                        document.getElementById("rating").value = movie.rating || "";
                                        document.getElementById("vote_count").value = movie.vote_count || "";
                                        document.getElementById("year").value = movie.year || "";
                                        document.getElementById("country").value = movie.country || "";
                                        document.getElementById("producer").value = movie.producer || "";
                                        document.getElementById("genre").value = movie.genre || "";
                                        document.getElementById("director").value = movie.director || "";
                                        document.getElementById("cast").value = movie.cast || "";

                                        // Cập nhật trạng thái
                                        const statusInput = document.getElementById("status");
                                        const statusBtn = document.getElementById("statusBtn");

                                        if (movie.status === "Coming") {
                                            statusBtn.className = "btn btn-warning";
                                            statusBtn.textContent = "Coming";
                                            statusInput.value = "Coming";
                                        } else if (movie.status === "Showing") {
                                            statusBtn.className = "btn btn-primary";
                                            statusBtn.textContent = "Showing";
                                            statusInput.value = "Showing";
                                        } else if (movie.status === "Ended") {
                                            statusBtn.className = "btn btn-danger";
                                            statusBtn.textContent = "Ended";
                                            statusInput.value = "Ended";
                                        }

                                        // Cuộn đến form để hiển thị
                                        document.getElementById("display").scrollIntoView({ behavior: "smooth" });
                                    }

                                    
                                </script>
                            </tbody>
                        </table>
                       



                    </div>

                </div>

                <!-- Thêm movie -->
                <div class="card">
                    <div class="card-header">
                        <div class="h3">Cập nhật/ Thêm mới</div>
                    </div>
                    <div class="card-body">
                    <form id="display" action="<?=ROOT?>poster/insert" method="post" enctype="multipart/form-data" class="border p-3 rounded">
                        <input type="hidden" id="id" name="id" value="">
                            <div class="mb-3">
                                <label for="movie" class="form-label">
                                    Chọn ảnh movie
                                    <span style="color: red">*</span>
                                </label>
                                <input type="file" id="file" name="file" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">
                                    URL (mặc định)
                                </label>
                                <input type="text" id="url" name="url" class="form-control" readonly>

                                <!-- Cập nhật Url -->
                                <script>
                                    document.getElementById("file").addEventListener("change", function(event) {
                                        let file = event.target.files[0];
                                        if (file) {
                                            let fileName = file.name;
                                            document.getElementById("url").value = "<?=STORAGE?>app/main/movies/" + fileName;
                                        }
                                        if (document.getElementById("url")) document.getElementById("url").addEventListener("change", updateStatus);

                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label for="trailer" class="form-label">
                                    Link trailer
                                </label>
                                <input type="text" id="trailer" name="trailer" class="form-control" >
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Tiêu đề
                                    <span style="color: red">*</span>
                                </label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_code" class="form-label">
                                    Phân loại
                                    <span style="color: red">*</span>
                                </label>
                                <input type="text" id="category_code" name="category_code" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="premiere_date" class="form-label">
                                    Ngày có hiệu lực
                                    <span style="color: red">*</span>
                                </label>
                                <input type="date" id="premiere_date" name="premiere_date" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">
                                    Ngày hết hiệu lực
                                    <span style="color: red">*</span>
                                    <span id="expiration_date_error" style="color: red;"></span>
                                </label>
                                <input type="date" id="expiration_date" name="expiration_date" class="form-control" required>

                                <!-- Kiểm tra ngày hết hạn -->
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let today = new Date().toISOString().split("T")[0];
                                        let startDateInput = document.getElementById("premiere_date");
                                        let expirationDateInput = document.getElementById("expiration_date");
                                        let expirationDateError = document.getElementById("expiration_date_error");

                                        expirationDateInput.addEventListener("change", function () {
                                            if (expirationDateInput.value < startDateInput.value) {
                                                expirationDateError.textContent = "Ngày hết hiệu lực phải lớn hơn hoặc bằng ngày có hiệu lực: " + startDateInput.value;
                                            } else {
                                                expirationDateError.textContent = "";
                                            }
                                        });
                                    });
                                </script>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <button type="button" id="statusBtn" class="btn btn-secondary">Unknown</button>
                                <input type="hidden" id="status" name="status">

                                <!-- Cập nhật trángj thái -->
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let today = new Date().toISOString().split("T")[0];

                                        let startDateInput = document.getElementById("premiere_date");
                                        let expirationDateInput = document.getElementById("expiration_date");

                                        const statusBtn = document.getElementById("statusBtn");
                                        const statusInput = document.getElementById("status");

                                        function updateStatus() {
                                            let premiere_date = startDateInput.value;
                                            let exp = expirationDateInput.value;

                                            if (!premiere_date || !exp) return;

                                            if (premiere_date > today) {
                                                statusBtn.className = "btn btn-warning";
                                                statusBtn.textContent = "Coming";
                                                statusInput.value = "Coming";
                                            } else if (premiere_date <= today && exp >= today) {
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
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="time" class="form-label">Thời lượng (phút)</label>
                            <input type="number" id="time" name="time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Điểm đánh giá</label>
                            <input type="number" step="0.1" id="rating" name="rating" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="vote_count" class="form-label">Lượt đánh giá</label>
                            <input type="number" id="vote_count" name="vote_count" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Năm sản xuất</label>
                            <input type="number" id="year" name="year" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Quốc gia sản xuất</label>
                            <input type="text" id="country" name="country" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="producer" class="form-label">Nhà sản xuất</label>
                            <input type="text" id="producer" name="producer" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Thể loại phim</label>
                            <input type="text" id="genre" name="genre" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="director" class="form-label">Đạo diễn</label>
                            <input type="text" id="director" name="director" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="cast" class="form-label">Danh sách diễn viên chính</label>
                            <textarea id="cast" name="cast" class="form-control"></textarea>
                        </div>


                            <div id="message" class="h-3" >
                                <!-- Thông báo sẽ hiển thị tại đây -->
                                <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const data = <?php echo json_encode($data); ?>;
                                    const messageDiv = document.getElementById("message");

                                    console.log(data); // Debug dữ liệu nhận được từ PHP

                                    if (data.error) {
                                        messageDiv.className = "alert alert-danger"; 
                                        messageDiv.textContent = data.error;
                                        messageDiv.style.display = "block"; // Hiển thị lỗi
                                        alert(data.error);

                                    } else if (data.success) {
                                        renderMovies(data.movie);
                                        messageDiv.className = "alert alert-success"; 
                                        messageDiv.textContent = data.success;
                                        messageDiv.style.display = "block"; // Hiển thị thành công
                                        alert(data.success);



                                    } else {
                                        messageDiv.style.display = "none"; // Ẩn nếu không có thông báo
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
                                // Reset form
                                document.getElementById("display").reset();

                                // Reset các trường input, textarea, và select về giá trị rỗng
                                document.getElementById("url").value = ""; // URL
                                document.getElementById("trailer").value = ""; // Trailer
                                document.getElementById("title").value = ""; // Tiêu đề
                                document.getElementById("category_code").value = ""; // Phân loại
                                document.getElementById("premiere_date").value = ""; // Ngày có hiệu lực
                                document.getElementById("expiration_date").value = ""; // Ngày hết hiệu lực
                                document.getElementById("description").value = ""; // Mô tả
                                document.getElementById("time").value = ""; // Thời lượng
                                document.getElementById("rating").value = ""; // Điểm đánh giá
                                document.getElementById("vote_count").value = ""; // Lượt đánh giá
                                document.getElementById("year").value = ""; // Năm sản xuất
                                document.getElementById("country").value = ""; // Quốc gia sản xuất
                                document.getElementById("producer").value = ""; // Nhà sản xuất
                                document.getElementById("genre").value = ""; // Thể loại phim
                                document.getElementById("director").value = ""; // Đạo diễn
                                document.getElementById("cast").value = ""; // Danh sách diễn viên chính

                                // Reset trạng thái
                                document.getElementById("statusBtn").textContent = "Unknown";
                                document.getElementById("statusBtn").className = "btn btn-secondary";
                                document.getElementById("status").value = "";

                                // Reset ID ẩn
                                document.getElementById("id").value = "";

                                // Kích hoạt lại trường file nếu nó đã bị vô hiệu hóa
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
                                            this.action = "<?=ROOT?>movie/update";
                                        } else {
                                            this.action = "<?=ROOT?>movie/insert";
                                        }
                                    }
                                    
                                });
                            </script>
                        </form>
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