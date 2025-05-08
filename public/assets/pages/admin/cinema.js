
document.addEventListener('DOMContentLoaded', () => {
    const validationProduct = new JustValidate('#productForm');
    validationProduct
        .addField('[name="name"]', [{
                rule: 'required',
                errorMessage: 'Vui lòng nhập tên sản phẩm',
            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: 'Tên sản phẩm phải có ít nhất 2 ký tự',
            },
        ])
        .addField('[name="price"]', [{
                rule: 'required',
                errorMessage: 'Vui lòng nhập giá',
            },
            {
                rule: 'number',
                errorMessage: 'Giá phải là số hợp lệ',
            },
        ])
        .addField('[name="type"]', [{
            rule: 'required',
            errorMessage: 'Vui lòng chọn loại sản phẩm',
        }, ])
        .addField('[name="quality"]', [{
                rule: 'required',
                errorMessage: 'Vui lòng nhập số lượng',
            },
            {
                rule: 'number',
                errorMessage: 'Số lượng phải là số hợp lệ',
            },
        ])
        .onSuccess(async (event) => {
            event.preventDefault();
            await submitProductForm(); // Gọi hàm xử lý gửi form
        });
    async function submitProductForm() {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);
        const cinemaId = document.getElementById("cinemaSelect").value;
        formData.append('cinema_id', cinemaId);
    
    
        try {
            const response = await fetch('http://localhost/CO3049_assignment/public/admin/insertProduct', {
                method: 'POST',
                body: formData
            });
    
            const data = await response.json();
            alert(data.message || 'Thêm sản phẩm thành công');
            form.reset();
            // Có thể gọi lại load dữ liệu sản phẩm ở đây
            loadProduct();
        } catch (err) {
            alert('Đã xảy ra lỗi khi gửi dữ liệu');
            console.error(err);
        }
    }
    
    const validation = new JustValidate('#cinemaInfoForm');
    validation
        .addField('input[name="name"]', [{
                rule: 'required',
                errorMessage: 'Vui lòng nhập tên rạp'
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'Tên rạp ít nhất 3 ký tự'
            }
        ])
        .addField('input[name="location"]', [{
                rule: 'required',
                errorMessage: 'Vui lòng nhập địa chỉ'
            },
            {
                rule: 'minLength',
                value: 5,
                errorMessage: 'Địa chỉ ít nhất 5 ký tự'
            }
        ])
        .addField('input[name="open_time"]', [{
            rule: 'required',
            errorMessage: 'Vui lòng chọn giờ mở cửa'
        }])
        .addField('input[name="close_time"]', [{
            rule: 'required',
            errorMessage: 'Vui lòng chọn giờ đóng cửa'
        }])
        .onSuccess(async (event) => {
            event.preventDefault(); // Ngăn reload mặc định
            await submitCinemaInfo(); // Gọi khi form hợp lệ
        });
    async function submitCinemaInfo() {
        const formData = new FormData(document.getElementById('cinemaInfoForm'));
    
        try {
            const response = await fetch('http://localhost/CO3049_assignment/public/admin/updateCinema', {
                method: 'POST',
                body: formData,
            });
    
            const data = await response.json();
            const messageDiv = document.getElementById('message');
            messageDiv.style.display = 'block';
            messageDiv.className = 'alert ' + (data.status ? 'alert-success' : 'alert-danger');
            messageDiv.innerText = data.message || (data.status ? 'Cập nhật thành công' : 'Cập nhật thất bại');
    
        } catch (error) {
            console.error('Lỗi khi gửi dữ liệu:', error);
            const messageDiv = document.getElementById('message');
            messageDiv.style.display = 'block';
            messageDiv.className = 'alert alert-danger';
            messageDiv.innerText = 'Có lỗi xảy ra khi gửi yêu cầu.';
        }
    }
    
    const params = new URLSearchParams(window.location.search);
    const view = params.get('view');
    
    // Ẩn tất cả các form
    document.getElementById('cinemaPage').style.display = 'none';
    document.getElementById('seatPage').style.display = 'none';
    document.getElementById('showtimePage').style.display = 'none';
    document.getElementById('productPage').style.display = 'none';
    
    // Hiện form tương ứng
    if (view === 'seatPage') {
        document.getElementById('seatPage').style.display = 'block';
    } else if (view === 'showtimePage') {
        document.getElementById('showtimePage').style.display = 'block';
    } else if (view === 'productPage') {
        document.getElementById('productPage').style.display = 'block';
    } else {
        document.getElementById('cinemaPage').style.display = 'block';
    }

    // Xử lý active menu
    const links = document.querySelectorAll('#chosePage a');
    links.forEach(link => {
        link.classList.remove('active');

        const url = new URL(link.href);
        const linkView = url.searchParams.get('view');

        if (view === linkView || (view === null && linkView === 'cinemaPage')) {
            link.classList.add('active');
        }
    });

    

    loadSelectCinema();
});

function resetForm(formId) {
    const form = document.getElementById(formId);  // Chọn form theo ID
    if (form) {
        form.reset();  // Reset form (clear các input)
    }
}



async function loadSelectCinema() {
    try {
        const response = await fetch("http://localhost/CO3049_assignment/public/admin/getCinema");
        const data = await response.json();

        const select = document.getElementById("cinemaSelect");
        select.innerHTML = "";


        if (data.status) {
            data.data.forEach((cinema, index) => {

                const option = document.createElement("option");
                option.value = cinema.id;
                option.textContent = cinema.name;
                option.setAttribute("data-open", cinema.open_time);
                option.setAttribute("data-close", cinema.close_time);
                if (index === 0) {
                    option.selected = true; // chọn option đầu tiên
                }
                select.appendChild(option);
            });
        } else {
            console.error("Dữ liệu rạp không hợp lệ");
        }
        loadSelectRoom();
        loadProduct();
        loadInfoCinema();
        loadTimeSelect();
    } catch (error) {
        console.error("Lỗi khi lấy danh sách rạp:", error);
    }
}

document.getElementById("cinemaSelect").addEventListener("change", function() {
    loadSelectRoom();
    loadProduct();
    loadInfoCinema();
    loadTimeSelect();
});

async function loadProduct() {
    try {
        const cinemaId = document.getElementById("cinemaSelect").value;

        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getProduct?cinema_id=${cinemaId}`);
        const result = await response.json();

        if (result.status && Array.isArray(result.data)) {
            // Destroy DataTable nếu đã khởi tạo
            if ($.fn.DataTable.isDataTable('#table1')) {
                $('#table1').DataTable().destroy();
            }

            const tbody = document.querySelector("#table1 tbody");
            tbody.innerHTML = "";

            result.data.forEach((item) => {
                const statusClass = {
                    available: "text-success fw-bold",
                    unavailable: "text-danger fw-bold",
                } [item.status] || "";

                const hasStockText = item.has_stock == 1 ? "✅ Có" : "❌ Không";

                const row = `
            <tr>
              <td>${item.id}</td>
              <td>${item.name}</td>
              <td>${parseFloat(item.price).toLocaleString("vi-VN")} đ</td>
              <td>${item.type}</td>
              <td class="${statusClass}">${item.status}</td>
              <td>${item.quality}</td>
              <td>${hasStockText}</td>
              <td>
                <button class="btn btn-sm btn-warning me-1" onclick="editProduct(${item.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${item.id})">Delete</button>
              </td>
            </tr>
          `;
                tbody.insertAdjacentHTML("beforeend", row);
            });

            // Khởi tạo lại DataTable sau khi render xong
            $('#table1').DataTable();
        }
    } catch (err) {
        console.error("Lỗi khi load sản phẩm:", err);
    }
}

async function editProduct(id) {
    try {
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getProduct?id=${id}`);
        const res = await response.json();

        if (res.status) {
            const product = res.data;
            const modal = document.getElementById("productModal");

            // Gán dữ liệu vào form
            modal.querySelector('#productModal input[name="id"]').value = product.id;
            modal.querySelector('#productModal  input[name="name"]').value = product.name;
            modal.querySelector('#productModal input[name="price"]').value = product.price;
            modal.querySelector('#productModal select[name="type"]').value = product.type;
            modal.querySelector('#productModal input[name="quality"]').value = product.quality;
            // Giả sử product.has_stock là false
            // Assuming product.has_stock is either true or false
            let hasStockValue = product.has_stock ? "1" : "0";

            // Set the checked radio button based on the value of product.has_stock
            modal.querySelector(`#productModal input[name="has_stock"][value="${hasStockValue}"]`).checked = true;

            // Mở modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    } catch (err) {
        console.error("Lỗi khi lấy sản phẩm:", err);
    }
}

async function deleteProduct(id) {
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này?")) return;

    try {
        const formData = new FormData();
        formData.append('id', id); // Thêm ID của sản phẩm cần xóa

        const response = await fetch('http://localhost/CO3049_assignment/public/admin/deleteProduct', {
            method: 'POST', // Sử dụng POST để gửi yêu cầu
            body: formData, // Gửi formData chứa dữ liệu
        });
        const res = await response.json();

        if (res.status) {
            alert("Xóa thành công!");
            loadProduct(); // Reload lại danh sách
        } else {
            alert("Xóa thất bại!");
        }
    } catch (err) {
        console.error("Lỗi khi xóa sản phẩm:", err);
    }
}

function toggleSeatCodeInput() {
    const seatType = document.querySelector("#seatModal select[name='type']");
    const seatCode = document.querySelector("#seatModal input[name='code']");
    const seatPrice = document.querySelector("#seatModal input[name='price']");

    if (seatType.value === "none") {
        seatCode.disabled = true; // Disable nếu chọn "none"

    } else {
        seatCode.disabled = false; // Enable nếu chọn loại ghế khác
    }
}

async function openInsertModal(row, col, code) {
    document.querySelector("#seatModal input[name='code']").value = code || "";
    document.querySelector("#seatModal input[name='col']").value = col || 1;
    document.querySelector("#seatModal input[name='row']").value = row || 1;
    document.querySelector("#seatModal input[name='room_id']").value = document.getElementById("roomSelect").value;
    const seatModal = new bootstrap.Modal(document.getElementById('seatModal'));
    seatModal.show();
}

async function insertSeat() {
    const form = document.getElementById("seatForm");
    const formData = new FormData(form);
    const price = parseFloat(form.querySelector("input[name='price']").value);
    if (price < 1000 || !price) {
        event.preventDefault();  // Ngừng gửi form
        alert("Giá trị của price phải lớn hơn 1000 .");
        return;
    } 
    const response = await fetch("http://localhost/CO3049_assignment/public/admin/insertSeat", {
        method: "POST",
        body: formData
    });
    const data = await response.json();
    if (data.status) {
        bootstrap.Modal.getInstance(document.getElementById('seatModal')).hide();
        loadSeat();
        resetForm("seatForm");
    } else {
        alert("Thêm ghế thất bại!");
    }
}

async function deleteSeat() {
    const form = document.getElementById("seatForm");
    const formData = new FormData(form);
    const response = await fetch("http://localhost/CO3049_assignment/public/admin/deleteSeat", {
        method: "POST",
        body: formData
    });
    const data = await response.json();
    console.log(data);
    if (data.status) {
        bootstrap.Modal.getInstance(document.getElementById('seatModal')).hide();
        loadSeat();
        resetForm("seatForm");
    } else {
        alert("Thêm ghế thất bại!");
    }
}

document.getElementById("dateSelect").addEventListener("change", function() {
    loadShowtime();
});

async function loadInfoCinema() {
    const cinemaId = document.getElementById("cinemaSelect").value;
    console.log(cinemaId); // Kiểm tra ID của rạp đã chọn
    if (!cinemaId) return; // Nếu không có rạp được chọn, thoát

    try {
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getCinema?id=${cinemaId}`);
        const res = await response.json();

        if (res.status) {
            const cinema = res.data[0];
            // Cập nhật vào form
            document.querySelector('#cinemaInfoForm input[name="id"]').value = cinema.id;
            document.querySelector('#cinemaInfoForm input[name="name"]').value = cinema.name;
            document.querySelector('#cinemaInfoForm input[name="location"]').value = cinema.location;
            document.querySelector('#cinemaInfoForm input[name="open_time"]').value = cinema.open_time;
            document.querySelector('#cinemaInfoForm input[name="close_time"]').value = cinema.close_time;
        } else {
            alert("Không tìm thấy thông tin rạp.");
        }
    } catch (error) {
        console.error('Có lỗi xảy ra khi lấy dữ liệu:', error);
        alert('Có lỗi xảy ra khi tải thông tin rạp.');
    }
}

async function loadSelectRoom() {
    try {
        const cinemaId = document.getElementById("cinemaSelect").value;
        const roomSelect = document.getElementById("roomSelect");
        roomSelect.innerHTML = ''; // Reset danh sách
        roomSelect.disabled = true;

        if (!cinemaId) return;
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getRoom?cinema_id=${cinemaId}`);
        const data = await response.json();
        console.log(data);

        if (data.status) {
            roomSelect.disabled = false;
            data.data.forEach((room, index) => {
                const option = document.createElement("option");
                option.value = room.id;
                option.textContent = room.name;

                if (index === 0) {
                    option.selected = true; // chọn option đầu tiên
                }

                roomSelect.appendChild(option);
            });

        }
        loadSeat();
        loadSelectDate();
    } catch (error) {
        console.error("Lỗi khi lấy danh sách phòng chiếu:", error);
    }
}
document.getElementById("roomSelect").addEventListener("change", function() {
    loadSeat();
});

async function loadSeat() {
    try {
        document.querySelector("#seatModal input[name='room_id']").value = document.getElementById("roomSelect").value;

        const roomId = document.getElementById("roomSelect").value;
        const seat = document.getElementById("seat");
        seat.innerHTML = ''; // Reset danh sách ghế

        if (!roomId) return;
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getSeat?room_id=${roomId}`);
        const data = await response.json();
        if (data.status) {
            const seat = document.getElementById("seat");
            seat.innerHTML = "";
            const seatData = data.data;



            const rowMap = {};
            seatData.forEach(seat => {
                if (!rowMap[seat.row]) {
                    rowMap[seat.row] = [];
                }
                rowMap[seat.row].push(seat);
            });


            const col1 = document.createElement("div");
            col1.classList.add('col-2', 'd-flex', 'flex-column', 'p-0');
            const col2 = document.createElement("div");
            col2.classList.add('col-10', 'text-start', 'overflow-auto', 'p-0');
            col2.style.whiteSpace = "nowrap";


            Object.entries(rowMap).forEach(([rowIndex, seats]) => {
                const rowSeat2 = document.createElement("div");
                rowSeat2.className = "rowSeat";

                const rowSeat1 = document.createElement("div");
                rowSeat1.className = "rowSeat";


                const label = document.createElement("button");
                label.classList.add('seat', 'none');

                label.textContent = String.fromCharCode(64 + parseInt(rowIndex));
                rowSeat1.appendChild(label);
                col1.appendChild(rowSeat1);


                let numSeat = 0;


                seats.forEach(seat => {
                    if (seat.type !== 'none') {
                        numSeat += 1;
                    }

                    const button = document.createElement("button");
                    button.classList.add("border-0");
                    if (seat.type === 'couple') {
                        button.classList.add("doubleSeat");
                    } else {
                        button.classList.add("seat");
                    }

                    button.classList.add(seat.type); 

                    button.innerHTML = seat.code || "&nbsp;";
                    button.addEventListener("click", () => {
                        loadSeatInfoToForm(seat);
                        
                        const seatModal = new bootstrap.Modal(document.getElementById("seatModal"));
                        seatModal.show();
                    });
                    rowSeat2.appendChild(button);
                });


                const colLength = Object.keys(rowMap[rowIndex]).length;
                const button = document.createElement("button");
                button.className = "seat add";
                button.textContent = "+";
                button.onclick = () => openInsertModal(rowIndex, colLength + 1, label.textContent + (numSeat + 1));
                rowSeat2.appendChild(button);
                col2.appendChild(rowSeat2);

            });

            const rowSeat2 = document.createElement("div");
            rowSeat2.className = "rowSeat";

            const rowSeat1 = document.createElement("div");
            rowSeat1.className = "rowSeat";



            const rowLength = Object.keys(rowMap).length;
            const label = document.createElement("button");
            label.classList.add('seat', 'none');
            label.textContent = String.fromCharCode(64 + parseInt(rowLength + 1));
            rowSeat1.appendChild(label);
            col1.appendChild(rowSeat1);

            const button = document.createElement("button");
            button.className = "seat add";
            button.textContent = "+";
            button.onclick = () => openInsertModal(rowLength + 1, 1, label.textContent + "1"); // Mở modal thêm ghế với mã ghế là "A1"
            rowSeat2.appendChild(button);
            col2.appendChild(rowSeat2);

            seat.appendChild(col1);
            seat.appendChild(col2);

        } else {
            const col1 = document.createElement("div");
            col1.classList.add('col-3', 'd-block');
            const col2 = document.createElement("div");
            col2.classList.add('col-9', 'text-start', 'overflow-auto');
            col2.style.whiteSpace = "nowrap";



            const label = document.createElement("button");
            label.classList.add('seat', 'none');
            label.textContent = "A";
            const button = document.createElement("button");
            button.className = "seat add";
            button.textContent = "+";
            button.onclick = () => openInsertModal(1, 1, label.textContent + "1"); // Mở modal thêm ghế với mã ghế là "A1"
            col1.appendChild(label);

            col2.appendChild(button);

            seat.appendChild(col1);
            seat.appendChild(col2);

        }

    } catch (error) {
        console.error("Lỗi khi lấy danh sách ghế:", error);
    }
}

function loadSeatInfoToForm(seat) {
    const form = document.getElementById("seatForm");

    // Đảm bảo các input có thể thay đổi giá trị
    form.querySelector('[name="type"]').value = seat.type || 'standard';
    form.querySelector('[name="code"]').value = seat.code || '';
    form.querySelector('[name="price"]').value = seat.price || '';
    form.querySelector('[name="col"]').value = seat.col || '';
    form.querySelector('[name="row"]').value = seat.row || '';
    form.querySelector('[name="room_id"]').value = seat.room_id || '';
    form.querySelector('[name="id"]').value = seat.id || ''; // Nếu có ID ghế
}

function loadSelectDate() {
    function formatDate(date) {
        let day = ("0" + date.getDate()).slice(-2);
        let month = ("0" + (date.getMonth() + 1)).slice(-2);
        let year = date.getFullYear();
        return year + "-" + month + "-" + day;
    }

    const roomId = document.getElementById("roomSelect").value;

    const dateSelect = document.getElementById("dateSelect");
    dateSelect.innerHTML = '<option selected>Chọn ngày</option>'; // Reset danh sách
    dateSelect.disabled = true;

    if (!roomId) return; // Nếu không có phòng được chọn thì không làm gì cả.

    let today = new Date();
    let minDate = formatDate(today);

    let maxDate = new Date();
    maxDate.setDate(today.getDate() + 3);
    maxDate = formatDate(maxDate);

    dateSelect.disabled = false; // Mở khóa dropdown chọn ngày

    // Xóa các option cũ trong dropdown
    dateSelect.innerHTML = '<option selected>Chọn ngày</option>';

    // Duyệt qua các ngày từ hôm nay đến 7 ngày sau
    for (let i = 0; i <= 6; i++) {
        let currentDate = new Date();
        currentDate.setDate(today.getDate() + i);
        let formattedDate = formatDate(currentDate);

        // Tạo option cho từng ngày
        let option = document.createElement("option");
        option.value = formattedDate;
        option.textContent = formattedDate;
        if (i === 0) {
            option.selected = true; // Chọn ngày hôm nay
        }
        dateSelect.appendChild(option);
    }
    loadShowtime();
}

async function loadMovies() {
    try {
        const message = document.getElementById("message");
        message.textContent = "";
        const movieSelect = document.getElementById("movieSelect");
        movieSelect.innerHTML = '<option selected>Chọn phim</option>';

        const response = await fetch("http://localhost/CO3049_assignment/public/admin/getMedia?type=movie");
        const data = await response.json();
        if (data.status) {
            data.data.forEach(movie => {


                const startDate = new Date(movie.start_date);
                const now = new Date();
                if (startDate <= now) {
                    const option = document.createElement("option");
                    option.value = movie.id;
                    option.setAttribute("duration", movie.duration); // Lưu thời gian phim vào thuộc tính
                    option.textContent = movie.title;

                    movieSelect.appendChild(option);
                }
            });
        }

    } catch (error) {
        console.error("Lỗi khi tải danh sách phim:", error);
    }
}

async function loadTimeSelect() {
    try {
        const hourSelect = document.getElementById("hourSelect");
        const minuteSelect = document.getElementById("minuteSelect");
        const cinemaSelect = document.getElementById("cinemaSelect");

        const selectedOption = cinemaSelect.options[cinemaSelect.selectedIndex];
        const openTime = selectedOption.getAttribute("data-open");
        const closeTime = selectedOption.getAttribute("data-close");

        if (!openTime || !closeTime) return;

        const [openHour, openMinute] = openTime.split(':').map(Number);
        const [closeHour, closeMinute] = closeTime.split(':').map(Number);

        // Xóa các option cũ
        hourSelect.innerHTML = '<option value="" disabled selected>Chọn giờ</option>';
        minuteSelect.innerHTML = '<option value="" disabled selected>Chọn phút</option>';

        // Thêm giờ từ open đến close
        for (let h = openHour; h < closeHour; h++) {
            const hourStr = String(h).padStart(2, '0');
            const option = document.createElement('option');
            option.value = hourStr;
            option.textContent = hourStr;
            hourSelect.appendChild(option);
        }

        // Thêm phút mỗi 5 phút (00 → 55)
        for (let m = 0; m < 60; m += 5) {
            const minuteStr = String(m).padStart(2, '0');
            const option = document.createElement('option');
            option.value = minuteStr;
            option.textContent = minuteStr;
            minuteSelect.appendChild(option);
        }

    } catch (error) {
        console.error("Lỗi khi tải danh sách thời gian:", error);
    }
}

async function loadShowtime() {
    const roomId = document.getElementById("roomSelect").value;
    const date = document.getElementById("dateSelect").value;

    try {
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/getShowtimeForAdmin?room_id=${roomId}&date=${date}`);
        const data = await response.json();
        if (!data.status && !data.data) return; 
        const showtimes = data.data;

        // Nhóm các showtime theo phim và giữ nguyên định dạng thời gian
        const groupedShowtimes = showtimes.reduce((acc, item) => {
            const key = item.title;
            const startTime = new Date(item.start_time.replace(" ", "T") + "Z").getTime();
            const endTime = new Date(item.end_time.replace(" ", "T") + "Z").getTime();

            if (!acc[key]) {
                acc[key] = [];
            }
            acc[key].push({ 
                x: key, 
                y: [startTime, endTime],
                // Lưu trữ thời gian gốc để hiển thị trong tooltip
                start: item.start_time,  // Giữ nguyên định dạng "YYYY-MM-DD HH:mm:ss"
                end: item.end_time       // Giữ nguyên định dạng "YYYY-MM-DD HH:mm:ss"
            });
            return acc;
        }, {});

        // Chuyển đổi thành series cho ApexCharts
        const seriesData = Object.keys(groupedShowtimes).map(title => ({
            name: title,
            data: groupedShowtimes[title]
        }));

        const options = {
            chart: {
                type: 'rangeBar',
                height: 350,  // Tăng chiều cao để tooltip hiển thị rõ
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '70%'
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'HH:mm'  // Hiển thị giờ:phút trên trục
                }
            },
            series: seriesData,
            tooltip: {
                custom: function({ series, seriesIndex, dataPointIndex, w }) {
                    // Truy cập đúng dữ liệu từ series
                    const dataPoint = w.config.series[seriesIndex].data[dataPointIndex];
                    const startTime = dataPoint.start;  // Lấy từ trường "start" đã lưu
                    const endTime = dataPoint.end;      // Lấy từ trường "end" đã lưu
                    
                    return `
                        <div style="padding: 8px; background: #fff; border: 1px solid #ddd; border-radius: 4px;">
                            <strong>${w.config.series[seriesIndex].name}</strong><br/>
                            <div style="margin-top: 5px;">
                                <span style="color: #666;">Bắt đầu:</span> ${startTime}<br/>
                                <span style="color: #666;">Kết thúc:</span> ${endTime}
                            </div>
                        </div>
                    `;
                }
            }
        };
        document.querySelector("#showtimeTimeline").innerHTML = '';
        const chart = new ApexCharts(document.querySelector("#showtimeTimeline"), options);
        chart.render();

    } catch (error) {
        console.error("Error loading showtime:", error);
    }
}

function editShowtime(id) {
    alert("Chức năng Sửa chưa được triển khai. ID: " + id);
}

async function deleteShowtime(id) {
    try {
        if (!confirm("Bạn có chắc chắn muốn xóa suất chiếu này không?")) return;
        const dataForm = new FormData();
        dataForm.append("id", id);
        const response = await fetch(`http://localhost/CO3049_assignment/public/admin/deleteShowtime`, {
            method: "POST",
            body: dataForm,
        });
        const data = await response.json();
        console.log(data);
        if (data.status) {
            loadShowtime();
        } else {
            console.error("Lỗi khi xóa suất chiếu:", data.message);
        }
    } catch (error) {
        console.error("Lỗi khi xóa suất chiếu:", error);
    }
}

async function getShowtimeCSV() {
    const cinemaId = document.getElementById("cinemaSelect").value;
    const roomId = document.getElementById("roomSelect").value;
    const date = document.getElementById("dateSelect").value;

    if (!cinemaId || !roomId || !date) {
        alert("Vui lòng chọn đầy đủ thông tin trước khi xuất CSV.");
        return;
    }

    const url = `http://localhost/CO3049_assignment/public/admin/getShowtimeCSV?&room_id=${roomId}&date=${date}`;
    window.location.href = url;
}

async function insertShowtime() {
    try {
        const showtime = document.getElementById("dateSelect").value;
        const roomId = document.getElementById("roomSelect").value;
        const movieId = document.getElementById("movieSelect").value;
        const hour = document.getElementById("hourSelect").value;
        const minute = document.getElementById("minuteSelect").value;
        const startTimeStr = `${showtime} ${hour}:${minute}:00`;
        let startTime = new Date(startTimeStr);

        const movieSelect = document.getElementById("movieSelect");
        const duration = movieSelect.options[movieSelect.selectedIndex].getAttribute("duration");
        let endTime = new Date(startTime.getTime() + duration * 60000);

        function formatDateTime(date) {
            const pad = n => n.toString().padStart(2, '0');
            return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} ` +
                `${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
        }

        startTime = formatDateTime(startTime);
        endTime = formatDateTime(endTime);
        console.log("Start Time:", startTime);
        console.log("End Time:", endTime);




        if (!showtime || !roomId || !movieId || !startTime) return;
        const dataForm = new FormData();
        dataForm.append("date", showtime);
        dataForm.append("room_id", roomId);
        dataForm.append("media_id", movieId);
        dataForm.append("start_time", startTime);
        dataForm.append("end_time", endTime);



        const response = await fetch("http://localhost/CO3049_assignment/public/admin/insertShowtime", {
            method: "POST",
            body: dataForm,
        });
        const data = await response.json();
        console.log(data);
        if (data.status) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('showtimeModal'));
            const message = document.getElementById("message");
            message.textContent = "";
            modal.hide();


            loadShowtime();
        } else {
            // Hiển thị thông báo lỗi cho người dùng
            const message = document.getElementById("message");
            message.textContent = data.message.error || "Có lỗi xảy ra. Vui lòng thử lại.";
        }

    } catch (error) {
        console.error("Lỗi khi thêm lịch chiếu:", error);
    }
}

function inputShowtime() {
    try {
        const showtime = document.getElementById("dateSelect").value;
        const roomId = document.getElementById("roomSelect").value;

        if (!showtime || !roomId) return;
        loadMovies();
        const myModal = new bootstrap.Modal(document.getElementById('showtimeModal'), {
            keyboard: false
        });
        loadTimeSelect();
        myModal.show();
    } catch (error) {
        console.error("Lỗi khi mở modal:", error);
    }
}



// Thêm sự kiện vào select khi modal mở
const seatTypeSelect = document.querySelector("#seatModal select[name='type']");
seatTypeSelect.addEventListener("change", toggleSeatCodeInput);

const seatModal = document.getElementById('seatModal');
seatModal.addEventListener('shown.bs.modal', function() {
    toggleSeatCodeInput();
});


