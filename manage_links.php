<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <title>Link Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            color: #333;
        }
        .container {
    max-width: 1200px;
    margin: 0 auto;
}
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        form label {
            margin-right: 10px;
            font-size: 18px;
        }

        input[type="text"] {
            font-size: 18px;
            padding: 5px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 400px;
        }

        input[type="submit"] {
            font-size: 18px;
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
            font-size: 18px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #f00;
            text-decoration: none;
        }

        .percentage-input {
            width: 80px;
            text-align: center;
            font-size: 18px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        td {
            text-align: center;
            font-size: 18px;
        }
        

         #update-btn {
            display: block;
            font-size: 20px;
            padding: 5px 20px;
            border-radius: 5px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            text-align: center;
            margin: 0 auto 20px;
        }
        
        #update-btn:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            font-size: 18px;
            padding: 5px 15px;
            border-radius: 5px;
            border: none;
            background-color: #dc3545;
            color: #fff;
            cursor: pointer;
            float: right;
            margin-left: 10px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        
        #random-link-display {
    text-align: center;
    font-size: 18px;
    border-radius: 8px;
}

#random-link {
    display: inline-block;
    padding: 8px 12px;
    background-color: #f2f2f2;
    border: 2px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    color: #333;
}

#random-link:hover {
    background-color: #e0e0e0;
    border-color: #999;
}

.refresh-btn {
    font-size: 16px;
    border-radius: 10px;
    padding: 5px 15px;
    border: none;
    background-color: #28a745;
    color: #fff;
    cursor: pointer;
    margin-left: 25px
}

.refresh-btn:hover {
    background-color: #218838;
}
button.delete-link {
    font-size: 16px;
    padding: 5px 10px;
    border-radius: 5px;
    border: none;
    background-color: #dc3545;
    color: #fff;
    cursor: pointer;
}

button.delete-link:hover {
    background-color: #c82333;
}
.username-display{
    color: red;
}
    </style>
    <script>
        function addLink() {
    const link = document.getElementById("link").value;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "add_link.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "success") {
                window.location.href = window.location.href;
                location.reload();
            } else {
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            }
        }
    };
    xhr.send("link=" + encodeURIComponent(link));
}

function deleteLink(id) {
    if (confirm("Bạn có chắc chắn muốn xóa liên kết này không?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_link.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "success") {
                    location.reload();
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id));
    }
}


function updatePercentages(validate = false) {
    const percentageInputs = document.querySelectorAll('.percentage-input');
    let data = [];
    let totalPercentage = 0;

    percentageInputs.forEach(input => {
        let inputValue = parseFloat(input.value);
        if (inputValue < 0) {
            document.getElementById('error-message').innerText = 'Giá trị phần trăm không được nhỏ hơn 0.';
            document.getElementById('error-message').style.display = 'block';
            return;
        }
        totalPercentage += inputValue;
        data.push({
            id: input.dataset.id,
            percentage: input.value
        });
    });

    if (validate && totalPercentage !== 100) {
        document.getElementById('error-message').innerText = 'Tổng giá trị phần trăm lưu lượng truy cập phải bằng 100.';
        document.getElementById('error-message').style.display = 'block';
        return;
    } else {
        document.getElementById('error-message').style.display = 'none';
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_percentages.php', true);
    xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log("Response text:", xhr.responseText); // Thêm dòng này
        const response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
           
            location.reload();
            if (response.random_link) {
    document.getElementById('random-link').innerText = response.random_link;
} else {
    document.getElementById('random-link').innerText = '';
}

        } else {
            document.getElementById('error-message').innerText = 'Có lỗi xảy ra, vui lòng thử lại.';
            document.getElementById('error-message').style.display = 'block';
        }
    }
};

    xhr.send(JSON.stringify(data));
}

function init() {
    document.querySelectorAll("button.delete-link").forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            deleteLink(event.target.dataset.id);
        });
    });
}
function copyRandomLink() {
    const randomLinkElement = document.getElementById("random-link");
    const selection = window.getSelection();
    const range = document.createRange();
    range.selectNodeContents(randomLinkElement);
    selection.removeAllRanges();
    selection.addRange(range);

    try {
        const successful = document.execCommand("copy");
        if (successful) {
            alert("Đã sao chép đường link ngẫu nhiên vào clipboard!");
        } else {
            alert("Không thể sao chép đường link. Vui lòng thử lại hoặc sao chép thủ công.");
        }
    } catch (err) {
        alert("Không thể sao chép đường link. Vui lòng thử lại hoặc sao chép thủ công.");
    }

    selection.removeAllRanges();
}

document.querySelectorAll(".link-input").forEach(function(input) {
    input.addEventListener("change", function(event) {
        const id = event.target.dataset.id;
        const link = event.target.value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_link.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText !== "success") {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id) + "&link=" + encodeURIComponent(link));
    });
});

document.querySelectorAll(".notes-input").forEach(function(input) {
    input.addEventListener("change", function(event) {
        const id = event.target.dataset.id;
        const notes = event.target.value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_notes.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText !== "success") {
                    alert("Có lỗi xảy ra, vui lòng thử lại.");
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id) + "&notes=" + encodeURIComponent(notes));
    });
});

window.onload = function() {
    init();
};

    </script>

    
</head>
<body>
    <div class="container">
   <h1>Tài khoản - <span class="username-display"><?php if (isset($_SESSION['username'])) echo htmlspecialchars($_SESSION['username']); ?></span><a href="logout.php" class="logout-btn">Đăng xuất</a></h1>
    <form onsubmit="event.preventDefault(); addLink();">
        <label for="link">Thêm liên kết:</label>
        <input type="text" id="link" name="link" required>
        <input type="submit" value="Thêm">
  <button class="refresh-btn" onclick="location.reload();"><i class="fa fa-sync-alt"></i> Làm mới</button>
    </form>
    
    <p id="random-link-display"><span id="random-link" onclick="copyRandomLink()"><?php if (isset($_SESSION['random_link'])) echo $_SESSION['random_link']; ?></span></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Liên kết</th>
            <th>Số lượt truy cập</th>
            <th>Phần trăm lưu lượng truy cập</th>
            <th>Hành động</th>
        </tr>
        <?php include 'fetch_links.php'; ?>
    </table>
    <button id="update-btn" onclick="updatePercentages(true);">Cập nhật</button>
    <span id="error-message" style="display: none; color: red; text-align: center; margin-top: 10px;"></span>
    document.querySelectorAll(".link-input").forEach(function(input) {
    input.addEventListener("change", function(event) {
        const id = event.target.dataset.id;
        const link = event.target.value;
        // Send a POST request to update_link.php
    });
});

    
    </div>
</body>
</html>
