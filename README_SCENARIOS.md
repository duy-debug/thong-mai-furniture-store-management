# README_SCENARIOS.md
# Tài liệu mô tả kịch bản chi tiết các chức năng

## 1. Mục đích

Tài liệu này mô tả kịch bản chi tiết của các chức năng trong hệ thống quản lý cửa hàng nội thất Thông Mai.

AI hoặc lập trình viên cần đọc tài liệu này trước khi code để hiểu:

- Ai được dùng chức năng
- Cần quyền gì
- Dữ liệu đầu vào là gì
- Xử lý như thế nào
- Trường hợp lỗi ra sao
- Bảng cơ sở dữ liệu nào liên quan

---

## 2. Quy ước chung

Mỗi chức năng được mô tả theo mẫu:

- Tên chức năng
- Tác nhân
- Quyền yêu cầu
- Điều kiện trước
- Dữ liệu đầu vào
- Luồng xử lý chính
- Luồng lỗi / thay thế
- Kết quả đầu ra
- Bảng CSDL liên quan
- Ghi chú khi code

---

## 3. Kịch bản chức năng

## 3.1 Đăng ký tài khoản

### Tên chức năng

Đăng ký tài khoản khách hàng.

### Tác nhân

Khách vãng lai.

### Quyền yêu cầu

Không yêu cầu đăng nhập.

### Điều kiện trước

Người dùng chưa đăng nhập.

### Dữ liệu đầu vào

- Họ tên
- Email
- Số điện thoại
- Mật khẩu
- Xác nhận mật khẩu
- Địa chỉ mặc định nếu có

### Luồng xử lý chính

1. Người dùng mở form đăng ký.
2. Người dùng nhập thông tin.
3. Hệ thống validate dữ liệu.
4. Hệ thống kiểm tra email đã tồn tại chưa.
5. Hệ thống kiểm tra số điện thoại đã tồn tại chưa nếu dùng làm thông tin đăng nhập.
6. Hệ thống hash mật khẩu.
7. Hệ thống tạo tài khoản mới trong `users`.
8. Hệ thống gán vai trò `customer`.
9. Hệ thống thông báo đăng ký thành công.

### Luồng lỗi / thay thế

- Nếu thiếu thông tin bắt buộc, báo lỗi.
- Nếu email sai định dạng, báo lỗi.
- Nếu email đã tồn tại, báo lỗi.
- Nếu số điện thoại đã tồn tại, báo lỗi.
- Nếu mật khẩu và xác nhận mật khẩu không khớp, báo lỗi.

### Kết quả đầu ra

Tài khoản khách hàng được tạo thành công.

### Bảng CSDL liên quan

- users
- roles
- role_user

### Ghi chú khi code

Mật khẩu bắt buộc phải hash, không lưu plain text.

---

## 3.2 Đăng nhập

### Tên chức năng

Đăng nhập hệ thống.

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

Không yêu cầu đăng nhập trước.

### Điều kiện trước

Người dùng đã có tài khoản.

### Dữ liệu đầu vào

- Email hoặc số điện thoại
- Mật khẩu

### Luồng xử lý chính

1. Người dùng mở trang đăng nhập.
2. Người dùng nhập email/số điện thoại và mật khẩu.
3. Hệ thống tìm tài khoản.
4. Hệ thống kiểm tra mật khẩu.
5. Hệ thống kiểm tra tài khoản có bị khóa không.
6. Hệ thống lấy vai trò của người dùng.
7. Hệ thống tạo session hoặc token.
8. Hệ thống điều hướng người dùng:
   - Khách hàng về giao diện khách hàng
   - Nhân viên vào trang quản trị nếu có quyền
   - Quản trị viên vào trang quản trị

### Luồng lỗi / thay thế

- Tài khoản không tồn tại
- Mật khẩu sai
- Tài khoản bị khóa
- Người dùng không có quyền vào trang quản trị

### Kết quả đầu ra

Đăng nhập thành công.

### Bảng CSDL liên quan

- users
- roles
- role_user
- permissions
- permission_role

---

## 3.3 Đăng xuất

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

Đã đăng nhập.

### Luồng xử lý chính

1. Người dùng nhấn đăng xuất.
2. Hệ thống xóa session hoặc token.
3. Hệ thống chuyển về trang đăng nhập hoặc trang chủ.

### Kết quả đầu ra

Người dùng đăng xuất thành công.

### Bảng CSDL liên quan

- users

---

## 3.4 Cập nhật thông tin cá nhân

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

Đã đăng nhập.

### Dữ liệu đầu vào

- Họ tên
- Số điện thoại
- Ngày sinh
- Giới tính
- Địa chỉ
- Cách liên hệ ưu tiên
- Ghi chú cá nhân

### Luồng xử lý chính

1. Người dùng mở trang hồ sơ cá nhân.
2. Hệ thống hiển thị dữ liệu hiện tại.
3. Người dùng chỉnh sửa thông tin.
4. Hệ thống validate dữ liệu.
5. Hệ thống lưu thay đổi vào `users`.

### Bảng CSDL liên quan

- users

---

## 3.5 Xem danh sách sản phẩm

### Tác nhân

Khách vãng lai, khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

Public đối với khách.

### Dữ liệu đầu vào

- Trang hiện tại
- Từ khóa nếu có
- Danh mục nếu có
- Khoảng giá nếu có
- Trạng thái còn hàng nếu có

### Luồng xử lý chính

1. Người dùng mở danh sách sản phẩm.
2. Hệ thống lấy sản phẩm đang hiển thị.
3. Hệ thống áp dụng bộ lọc nếu có.
4. Hệ thống phân trang.
5. Hệ thống trả về danh sách.

### Bảng CSDL liên quan

- products
- categories
- product_images

---

## 3.6 Xem chi tiết sản phẩm

### Tác nhân

Khách vãng lai, khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

Public đối với sản phẩm đang hiển thị.

### Dữ liệu đầu vào

- ID sản phẩm hoặc slug

### Luồng xử lý chính

1. Người dùng chọn một sản phẩm.
2. Hệ thống tìm sản phẩm.
3. Hệ thống lấy thông tin sản phẩm, danh mục và hình ảnh.
4. Hệ thống hiển thị chi tiết.

### Luồng lỗi / thay thế

- Sản phẩm không tồn tại thì báo 404
- Sản phẩm bị ẩn thì khách không được xem

### Bảng CSDL liên quan

- products
- categories
- product_images

---

## 3.7 Tìm kiếm sản phẩm

### Tác nhân

Khách vãng lai, khách hàng.

### Quyền yêu cầu

Public.

### Dữ liệu đầu vào

- Từ khóa
- Danh mục nếu có
- Khoảng giá nếu có

### Luồng xử lý chính

1. Người dùng nhập từ khóa.
2. Hệ thống tìm trong tên, mã, mô tả, chất liệu.
3. Hệ thống kết hợp bộ lọc nếu có.
4. Hệ thống trả về danh sách phù hợp.

### Luồng lỗi / thay thế

- Không tìm thấy thì hiển thị thông báo không có sản phẩm phù hợp

### Bảng CSDL liên quan

- products
- categories

---

## 3.8 Thêm vào giỏ hàng

### Tác nhân

Khách hàng.

### Quyền yêu cầu

`cart.add`.

### Điều kiện trước

Khách hàng đã đăng nhập.

### Dữ liệu đầu vào

- ID sản phẩm
- Số lượng

### Luồng xử lý chính

1. Khách hàng nhấn thêm vào giỏ.
2. Hệ thống kiểm tra đã đăng nhập chưa.
3. Hệ thống kiểm tra sản phẩm tồn tại.
4. Hệ thống kiểm tra sản phẩm còn hàng.
5. Hệ thống kiểm tra số lượng không vượt tồn kho.
6. Nếu sản phẩm đã có trong giỏ, tăng số lượng.
7. Nếu chưa có, thêm mới vào `cart_items`.
8. Hệ thống tính lại tổng tiền giỏ hàng.
9. Hệ thống thông báo thành công.

### Luồng lỗi / thay thế

- Chưa đăng nhập thì chuyển đến trang đăng nhập
- Sản phẩm không tồn tại thì báo lỗi
- Sản phẩm hết hàng thì báo lỗi
- Số lượng vượt tồn kho thì báo lỗi

### Bảng CSDL liên quan

- carts
- cart_items
- products

---

## 3.9 Cập nhật giỏ hàng

### Tác nhân

Khách hàng.

### Quyền yêu cầu

`cart.update`.

### Dữ liệu đầu vào

- ID sản phẩm trong giỏ
- Số lượng mới

### Luồng xử lý chính

1. Khách hàng mở giỏ hàng.
2. Khách hàng thay đổi số lượng hoặc xóa sản phẩm.
3. Hệ thống kiểm tra sản phẩm trong giỏ có tồn tại không.
4. Hệ thống kiểm tra số lượng hợp lệ.
5. Hệ thống cập nhật giỏ hàng.
6. Hệ thống tính lại tổng tiền.

### Bảng CSDL liên quan

- carts
- cart_items
- products

---

## 3.10 Đặt hàng

### Tác nhân

Khách hàng.

### Quyền yêu cầu

`order.create`.

### Điều kiện trước

- Khách hàng đã đăng nhập
- Giỏ hàng có sản phẩm

### Dữ liệu đầu vào

- Họ tên người nhận
- Số điện thoại
- Địa chỉ giao hàng
- Email nếu có
- Ghi chú
- Phương thức thanh toán

### Luồng xử lý chính

1. Khách hàng mở trang thanh toán.
2. Hệ thống hiển thị sản phẩm trong giỏ.
3. Khách hàng nhập thông tin giao hàng.
4. Hệ thống validate dữ liệu.
5. Hệ thống kiểm tra giỏ hàng không rỗng.
6. Hệ thống kiểm tra từng sản phẩm còn hàng.
7. Hệ thống kiểm tra số lượng không vượt tồn kho.
8. Hệ thống tạo đơn hàng trạng thái `pending`.
9. Hệ thống tạo chi tiết đơn hàng trong `order_items`.
10. Hệ thống xóa giỏ hàng.
11. Hệ thống thông báo đặt hàng thành công.

### Luồng lỗi / thay thế

- Giỏ hàng rỗng
- Sản phẩm hết hàng
- Số lượng vượt tồn kho
- Thiếu thông tin giao hàng

### Bảng CSDL liên quan

- orders
- order_items
- carts
- cart_items
- products
- users

### Ghi chú khi code

Nên dùng transaction khi tạo đơn hàng và chi tiết đơn hàng.

---

## 3.11 Xem lịch sử đơn hàng

### Tác nhân

Khách hàng.

### Quyền yêu cầu

`order.own_view`.

### Luồng xử lý chính

1. Khách hàng mở trang lịch sử đơn hàng.
2. Hệ thống lấy đơn hàng của user đang đăng nhập.
3. Hệ thống phân trang.
4. Hệ thống hiển thị danh sách.

### Bảng CSDL liên quan

- orders
- order_items

---

## 3.12 Xem chi tiết đơn hàng

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

- Khách hàng: `order.own_detail`
- Nhân viên / quản trị viên: `order.detail`

### Luồng xử lý chính

1. Người dùng chọn đơn hàng.
2. Hệ thống kiểm tra quyền.
3. Nếu là khách hàng, kiểm tra đơn hàng có thuộc về người đó không.
4. Hệ thống lấy thông tin đơn hàng.
5. Hệ thống lấy danh sách sản phẩm trong đơn.
6. Hệ thống hiển thị chi tiết.

### Bảng CSDL liên quan

- orders
- order_items
- products
- order_status_logs

---

## 3.13 Cập nhật trạng thái đơn hàng

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`order.update_status`.

### Dữ liệu đầu vào

- ID đơn hàng
- Trạng thái mới
- Ghi chú nếu có

### Luồng xử lý chính

1. Nhân viên mở chi tiết đơn hàng.
2. Nhân viên chọn trạng thái mới.
3. Hệ thống kiểm tra quyền.
4. Hệ thống kiểm tra trạng thái mới hợp lệ.
5. Nếu chuyển từ `pending` sang `processing`, kiểm tra tồn kho.
6. Nếu tồn kho đủ, hệ thống cập nhật trạng thái đơn hàng.
7. Hệ thống thêm dòng lịch sử vào `order_status_logs`.
8. Hệ thống thông báo cập nhật thành công.

### Luồng lỗi / thay thế

- Không có quyền
- Đơn hàng không tồn tại
- Trạng thái không hợp lệ
- Tồn kho không đủ

### Bảng CSDL liên quan

- orders
- order_items
- products
- order_status_logs

### Ghi chú khi code

Phải dùng transaction khi cập nhật trạng thái có liên quan đến tồn kho.

---

## 3.14 Hủy đơn hàng

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

- Khách hàng: chỉ hủy đơn của mình nếu trạng thái `pending`
- Nhân viên / quản trị viên: `order.cancel`

### Dữ liệu đầu vào

- ID đơn hàng
- Lý do hủy

### Luồng xử lý chính

1. Người dùng chọn hủy đơn.
2. Hệ thống kiểm tra quyền.
3. Hệ thống kiểm tra đơn hàng tồn tại.
4. Hệ thống kiểm tra trạng thái có được hủy không.
5. Nếu đơn chưa trừ kho, chỉ cập nhật trạng thái.
6. Nếu đơn đã trừ kho, cộng lại tồn kho.
7. Hệ thống lưu lý do hủy.
8. Hệ thống thêm lịch sử trạng thái.
9. Hệ thống thông báo hủy thành công.

### Bảng CSDL liên quan

- orders
- order_items
- products
- order_status_logs

---

## 3.15 Thêm sản phẩm

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`product.create`.

### Dữ liệu đầu vào

- Tên sản phẩm
- Mã sản phẩm
- Danh mục
- Mô tả
- Giá
- Kích thước
- Chất liệu
- Màu sắc
- Tồn kho
- Hình ảnh
- Trạng thái

### Luồng xử lý chính

1. Người dùng mở form thêm sản phẩm.
2. Nhập thông tin.
3. Hệ thống validate.
4. Hệ thống kiểm tra danh mục tồn tại.
5. Hệ thống upload hình ảnh nếu có.
6. Hệ thống lưu sản phẩm.
7. Hệ thống thông báo thêm thành công.

### Bảng CSDL liên quan

- products
- categories
- product_images

---

## 3.16 Cập nhật sản phẩm

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`product.update`.

### Luồng xử lý chính

1. Người dùng mở form sửa sản phẩm.
2. Hệ thống hiển thị thông tin hiện tại.
3. Người dùng thay đổi thông tin.
4. Hệ thống validate.
5. Hệ thống cập nhật sản phẩm.
6. Nếu có ảnh mới, cập nhật ảnh.

### Bảng CSDL liên quan

- products
- product_images

---

## 3.17 Xóa hoặc ẩn sản phẩm

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`product.delete`.

### Luồng xử lý chính

1. Người dùng chọn xóa hoặc ẩn sản phẩm.
2. Hệ thống kiểm tra quyền.
3. Hệ thống kiểm tra sản phẩm có phát sinh đơn hàng chưa.
4. Nếu chưa phát sinh đơn hàng, soft delete.
5. Nếu đã phát sinh đơn hàng, chuyển sang trạng thái ẩn.

### Bảng CSDL liên quan

- products
- order_items

---

## 3.18 Quản lý danh mục

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

- `category.view`
- `category.create`
- `category.update`
- `category.delete`

### Luồng thêm danh mục

1. Người dùng nhập tên danh mục.
2. Hệ thống validate.
3. Hệ thống lưu danh mục.

### Luồng sửa danh mục

1. Người dùng chọn danh mục.
2. Hệ thống hiển thị thông tin hiện tại.
3. Người dùng cập nhật.
4. Hệ thống lưu thay đổi.

### Luồng xóa danh mục

1. Người dùng chọn xóa.
2. Hệ thống kiểm tra danh mục còn sản phẩm không.
3. Nếu còn sản phẩm thì không cho xóa.
4. Nếu không còn thì soft delete.

### Bảng CSDL liên quan

- categories
- products

---

## 3.19 Quản lý khách hàng

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

- `customer.view`
- `customer.detail`
- `customer.lock`

### Luồng xem danh sách

1. Người dùng mở trang khách hàng.
2. Hệ thống kiểm tra quyền.
3. Hệ thống lấy danh sách khách hàng.
4. Hệ thống hỗ trợ tìm kiếm, lọc, phân trang.

### Luồng xem chi tiết

1. Người dùng chọn khách hàng.
2. Hệ thống hiển thị thông tin cá nhân.
3. Hệ thống hiển thị đơn hàng liên quan.

### Luồng khóa / mở khóa

1. Người dùng chọn khóa hoặc mở khóa.
2. Hệ thống yêu cầu lý do nếu khóa.
3. Hệ thống cập nhật trạng thái tài khoản.

### Bảng CSDL liên quan

- users
- orders
- design_requests

---

## 3.20 Quản lý người dùng nội bộ

### Tác nhân

Quản trị viên.

### Quyền yêu cầu

- `user.view`
- `user.create`
- `user.update`
- `user.lock`

### Luồng tạo người dùng

1. Quản trị viên mở form tạo người dùng.
2. Nhập họ tên, email, số điện thoại, mật khẩu, vai trò.
3. Hệ thống validate.
4. Hệ thống hash mật khẩu.
5. Hệ thống tạo người dùng.
6. Hệ thống gán vai trò.

### Luồng cập nhật người dùng

1. Quản trị viên chọn người dùng.
2. Cập nhật thông tin hoặc vai trò.
3. Hệ thống lưu thay đổi.

### Luồng khóa / mở khóa

1. Quản trị viên chọn khóa hoặc mở khóa.
2. Hệ thống kiểm tra không phải admin duy nhất.
3. Hệ thống cập nhật trạng thái.

### Bảng CSDL liên quan

- users
- roles
- role_user

---

## 3.21 Quản lý vai trò

### Tác nhân

Quản trị viên.

### Quyền yêu cầu

- `role.view`
- `role.create`
- `role.update`
- `role.delete`

### Luồng xử lý

1. Quản trị viên mở trang vai trò.
2. Hệ thống hiển thị danh sách vai trò.
3. Quản trị viên có thể thêm, sửa, xóa vai trò.
4. Khi xóa, hệ thống kiểm tra vai trò có đang được dùng không.

### Bảng CSDL liên quan

- roles
- role_user

---

## 3.22 Gán quyền cho vai trò

### Tác nhân

Quản trị viên.

### Quyền yêu cầu

`permission.assign`.

### Dữ liệu đầu vào

- ID vai trò
- Danh sách quyền

### Luồng xử lý chính

1. Quản trị viên chọn vai trò.
2. Hệ thống hiển thị danh sách quyền.
3. Quản trị viên chọn quyền cần gán.
4. Hệ thống lưu vào `permission_role`.

### Bảng CSDL liên quan

- roles
- permissions
- permission_role

---

## 3.23 Gửi yêu cầu thiết kế nội thất

### Tác nhân

Khách hàng.

### Quyền yêu cầu

`design_request.create`.

### Dữ liệu đầu vào

- Loại không gian
- Diện tích
- Địa chỉ không gian
- Phong cách mong muốn
- Màu sắc chủ đạo
- Ngân sách dự kiến
- Thời gian mong muốn
- Yêu cầu cụ thể

### Luồng xử lý chính

1. Khách hàng mở form yêu cầu thiết kế.
2. Nhập thông tin.
3. Hệ thống validate.
4. Hệ thống tạo yêu cầu với trạng thái `new`.
5. Hệ thống thông báo gửi yêu cầu thành công.

### Bảng CSDL liên quan

- design_requests
- users

---

## 3.24 Xem danh sách yêu cầu thiết kế

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`design_request.view`.

### Luồng xử lý chính

1. Người dùng mở trang yêu cầu thiết kế.
2. Hệ thống kiểm tra quyền.
3. Hệ thống lấy danh sách yêu cầu.
4. Hệ thống áp dụng bộ lọc nếu có.
5. Hệ thống phân trang.

### Bảng CSDL liên quan

- design_requests
- users

---

## 3.25 Xem chi tiết yêu cầu thiết kế

### Tác nhân

Khách hàng, nhân viên, quản trị viên.

### Quyền yêu cầu

- Khách hàng: xem yêu cầu của chính mình
- Nhân viên / quản trị viên: `design_request.detail`

### Luồng xử lý chính

1. Người dùng chọn yêu cầu thiết kế.
2. Hệ thống kiểm tra quyền.
3. Nếu là khách hàng, kiểm tra yêu cầu có thuộc về người đó không.
4. Hệ thống hiển thị chi tiết yêu cầu.

### Bảng CSDL liên quan

- design_requests
- users

---

## 3.26 Cập nhật trạng thái yêu cầu thiết kế

### Tác nhân

Nhân viên, quản trị viên.

### Quyền yêu cầu

`design_request.update_status`.

### Dữ liệu đầu vào

- ID yêu cầu
- Trạng thái mới
- Ghi chú nếu có

### Luồng xử lý chính

1. Người dùng mở chi tiết yêu cầu thiết kế.
2. Chọn trạng thái mới.
3. Hệ thống kiểm tra quyền.
4. Hệ thống kiểm tra trạng thái mới hợp lệ.
5. Hệ thống cập nhật trạng thái trong `design_requests`.
6. Hệ thống thông báo cập nhật thành công.

### Bảng CSDL liên quan

- design_requests

---

## 3.27 Kiểm tra phân quyền khi truy cập chức năng

### Tác nhân

Hệ thống.

### Quyền yêu cầu

Tùy route.

### Luồng xử lý chính

1. Người dùng truy cập route.
2. Middleware kiểm tra đăng nhập.
3. Middleware kiểm tra tài khoản có bị khóa không.
4. Middleware lấy vai trò.
5. Middleware kiểm tra quyền cần thiết.
6. Nếu có quyền, cho phép truy cập.
7. Nếu không có quyền, trả về 403.

### Bảng CSDL liên quan

- users
- roles
- permissions
- role_user
- permission_role

### Ghi chú khi code

Không kiểm tra quyền bằng cách hard-code vai trò. Phải kiểm tra bằng mã quyền.

---

## 4. Bảng cơ sở dữ liệu hiện tại

Nhóm người dùng và phân quyền:

- users
- roles
- permissions
- role_user
- permission_role

Nhóm sản phẩm:

- categories
- products
- product_images

Nhóm giỏ hàng và đơn hàng:

- carts
- cart_items
- orders
- order_items
- order_status_logs

Nhóm thiết kế:

- design_requests

---

## 5. Checklist khi code

- [ ] Đã tạo bảng users
- [ ] Đã tạo bảng roles
- [ ] Đã tạo bảng permissions
- [ ] Đã tạo bảng role_user
- [ ] Đã tạo bảng permission_role
- [ ] Đã tạo middleware kiểm tra quyền
- [ ] Đã tạo seeder vai trò mặc định
- [ ] Đã tạo seeder quyền mặc định
- [ ] Đã gán toàn bộ quyền cho admin
- [ ] Đã validate dữ liệu đầu vào
- [ ] Đã hash mật khẩu
- [ ] Đã xử lý đăng nhập / đăng xuất
- [ ] Đã xử lý giỏ hàng
- [ ] Đã xử lý đặt hàng bằng transaction
- [ ] Đã kiểm tra tồn kho khi xác nhận đơn
- [ ] Đã trừ kho đúng lúc
- [ ] Đã cộng lại kho khi hủy đơn đã trừ
- [ ] Đã phân quyền route
- [ ] Đã ẩn menu theo quyền
- [ ] Đã chặn khách hàng xem dữ liệu của người khác
- [ ] Đã chặn nhân viên tự cấp quyền cho chính mình

