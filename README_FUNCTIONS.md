# README_FUNCTIONS.md
# Tài liệu mô tả chức năng hệ thống quản lý cửa hàng nội thất Thông Mai

## 1. Giới thiệu

Hệ thống quản lý cửa hàng nội thất Thông Mai là website hỗ trợ:

- Giới thiệu sản phẩm
- Bán hàng trực tuyến
- Quản lý đơn hàng
- Quản lý sản phẩm và danh mục
- Quản lý yêu cầu thiết kế nội thất
- Quản lý người dùng nội bộ
- Phân quyền động theo vai trò và quyền

Hệ thống có 4 nhóm người dùng chính:

1. Khách vãng lai
2. Khách hàng
3. Nhân viên
4. Quản trị viên

Hệ thống phải dùng phân quyền động. Không hard-code quyền theo vai trò trong controller. Mỗi chức năng quản trị phải kiểm tra quyền trước khi thực hiện.

---

## 2. Mô hình dữ liệu rút gọn

Schema hiện tại được rút gọn để giữ đúng nghiệp vụ lõi, với các bảng chính:

- `users`
- `roles`
- `permissions`
- `role_user`
- `permission_role`
- `categories`
- `products`
- `product_images`
- `carts`
- `cart_items`
- `orders`
- `order_items`
- `order_status_logs`
- `design_requests`

Các bảng phụ trợ Laravel như `sessions`, `cache`, `jobs`, `password_reset_tokens` vẫn có thể tồn tại theo nhu cầu vận hành, nhưng không phải là bảng nghiệp vụ lõi.

Đã lược bỏ các phần sau để giảm độ phức tạp:

- `customer_profiles`
- `customer_addresses`
- `activity_logs`
- `product_stock_logs`
- `invoices`
- `design_request_files`
- `design_request_status_logs`

Thông tin khách hàng được lưu trực tiếp trong `users` và snapshot trong `orders`/`design_requests`.

---

## 3. Nhóm người dùng

### 3.1 Khách vãng lai

Được phép:

- Xem trang chủ
- Xem danh sách sản phẩm
- Tìm kiếm và lọc sản phẩm
- Xem chi tiết sản phẩm
- Đăng ký tài khoản
- Đăng nhập

Không được phép:

- Đặt hàng
- Thêm vào giỏ hàng
- Gửi yêu cầu thiết kế
- Truy cập trang quản trị

---

### 3.2 Khách hàng

Khách hàng là người đã đăng ký và đăng nhập.

Được phép:

- Xem và tìm kiếm sản phẩm
- Xem chi tiết sản phẩm
- Thêm vào giỏ hàng
- Cập nhật giỏ hàng
- Đặt hàng
- Xem lịch sử đơn hàng của chính mình
- Xem chi tiết đơn hàng của chính mình
- Cập nhật thông tin cá nhân
- Gửi yêu cầu thiết kế nội thất
- Xem yêu cầu thiết kế của chính mình
- Đăng xuất

Không được phép:

- Quản lý sản phẩm
- Quản lý danh mục
- Quản lý đơn hàng của người khác
- Quản lý người dùng nội bộ
- Quản lý vai trò và quyền
- Truy cập trang quản trị

---

### 3.3 Nhân viên

Nhân viên là người dùng nội bộ do quản trị viên tạo.

Nhân viên không có toàn quyền mặc định. Quyền của nhân viên do quản trị viên cấp động.

Có thể được cấp các quyền:

- Quản lý sản phẩm
- Quản lý danh mục
- Quản lý đơn hàng
- Cập nhật trạng thái đơn hàng
- Xem khách hàng
- Quản lý yêu cầu thiết kế
- Xem báo cáo

Không được phép mặc định:

- Quản lý vai trò
- Quản lý quyền
- Gán quyền
- Gán vai trò cho người dùng

---

### 3.4 Quản trị viên

Quản trị viên có quyền cao nhất trong hệ thống.

Được phép:

- Quản lý sản phẩm
- Quản lý danh mục
- Quản lý đơn hàng
- Quản lý khách hàng
- Quản lý yêu cầu thiết kế
- Quản lý người dùng nội bộ
- Quản lý vai trò
- Quản lý quyền
- Gán vai trò
- Gán quyền

---

## 4. Phân hệ chính

Hệ thống gồm các phân hệ:

1. Xác thực và tài khoản
2. Tìm kiếm và xem sản phẩm
3. Quản lý giỏ hàng
4. Đặt hàng
5. Quản lý đơn hàng
6. Quản lý sản phẩm
7. Quản lý danh mục
8. Quản lý khách hàng
9. Quản lý người dùng nội bộ
10. Quản lý yêu cầu thiết kế nội thất
11. Quản lý vai trò và phân quyền động

---

## 5. Xác thực và tài khoản

### 5.1 Đăng ký

Khách vãng lai có thể đăng ký tài khoản khách hàng.

Dữ liệu:

- Họ tên
- Email
- Số điện thoại
- Mật khẩu
- Xác nhận mật khẩu
- Địa chỉ mặc định nếu có

Quy tắc:

- Email không được trùng
- Số điện thoại không được trùng nếu dùng làm thông tin đăng nhập
- Mật khẩu phải hash trước khi lưu
- Tài khoản mới mặc định là `customer`

---

### 5.2 Đăng nhập

Người dùng đăng nhập bằng email hoặc số điện thoại và mật khẩu.

Hệ thống cần kiểm tra:

- Tài khoản tồn tại
- Mật khẩu đúng
- Tài khoản chưa bị khóa
- Vai trò hợp lệ

Sau khi đăng nhập:

- Khách hàng vào giao diện khách hàng
- Nhân viên vào trang quản trị nếu có quyền
- Quản trị viên vào trang quản trị

---

### 5.3 Đăng xuất

Người dùng đăng xuất khỏi hệ thống.

Hệ thống xóa session hoặc token đăng nhập.

---

### 5.4 Cập nhật thông tin cá nhân

Người dùng có thể cập nhật:

- Họ tên
- Số điện thoại
- Ngày sinh
- Giới tính
- Địa chỉ
- Cách liên hệ ưu tiên
- Ghi chú cá nhân

---

## 6. Tìm kiếm và xem sản phẩm

### 6.1 Xem danh sách sản phẩm

Hiển thị:

- Tên sản phẩm
- Hình ảnh đại diện
- Giá bán
- Danh mục
- Trạng thái còn hàng / hết hàng
- Nút xem chi tiết
- Nút thêm vào giỏ hàng đối với khách hàng

Hỗ trợ:

- Phân trang
- Sắp xếp
- Lọc theo danh mục
- Lọc theo giá
- Lọc theo trạng thái còn hàng

---

### 6.2 Xem chi tiết sản phẩm

Thông tin hiển thị:

- Mã sản phẩm
- Tên sản phẩm
- Hình ảnh
- Mô tả
- Giá bán
- Kích thước
- Chất liệu
- Màu sắc
- Danh mục
- Tồn kho
- Trạng thái

Nếu sản phẩm hết hàng, không cho thêm vào giỏ.

---

### 6.3 Tìm kiếm sản phẩm

Tìm kiếm theo:

- Tên sản phẩm
- Mã sản phẩm
- Danh mục
- Chất liệu
- Mô tả
- Khoảng giá

Nếu không có kết quả, hiển thị thông báo: `Không tìm thấy sản phẩm phù hợp`.

---

## 7. Giỏ hàng

### 7.1 Thêm vào giỏ hàng

Khách hàng đăng nhập được thêm sản phẩm vào giỏ.

Quy tắc:

- Sản phẩm phải tồn tại
- Sản phẩm đang hiển thị
- Sản phẩm còn hàng
- Số lượng thêm không vượt tồn kho
- Nếu sản phẩm đã có trong giỏ thì tăng số lượng
- Nếu chưa có thì tạo mới

---

### 7.2 Xem giỏ hàng

Hiển thị:

- Danh sách sản phẩm
- Hình ảnh
- Tên sản phẩm
- Số lượng
- Đơn giá
- Thành tiền
- Tổng tiền
- Nút cập nhật
- Nút xóa
- Nút đặt hàng

---

### 7.3 Cập nhật giỏ hàng

Khách hàng có thể:

- Tăng số lượng
- Giảm số lượng
- Xóa sản phẩm
- Làm trống giỏ hàng

Quy tắc:

- Số lượng phải lớn hơn 0
- Số lượng không vượt tồn kho
- Sau khi cập nhật phải tính lại tổng tiền

---

## 8. Đặt hàng

### 8.1 Tạo đơn hàng

Khách hàng đặt hàng từ giỏ hàng.

Dữ liệu:

- Họ tên người nhận
- Số điện thoại
- Email nếu có
- Địa chỉ giao hàng
- Ghi chú
- Phương thức thanh toán
- Danh sách sản phẩm
- Tổng tiền

Quy tắc:

- Khách hàng phải đăng nhập
- Giỏ hàng không rỗng
- Sản phẩm còn hàng
- Số lượng đặt không vượt tồn kho
- Tạo đơn hàng với trạng thái `pending`
- Tạo chi tiết đơn hàng
- Sau khi đặt hàng thành công, xóa giỏ hàng
- Chưa trừ kho khi mới đặt hàng, chỉ trừ kho khi nhân viên xác nhận đơn

---

### 8.2 Xem lịch sử đơn hàng

Khách hàng chỉ được xem đơn hàng của chính mình.

Thông tin:

- Mã đơn hàng
- Ngày đặt
- Tổng tiền
- Trạng thái
- Nút xem chi tiết

---

### 8.3 Xem chi tiết đơn hàng

Hiển thị:

- Mã đơn hàng
- Thông tin khách hàng
- Thông tin giao hàng
- Danh sách sản phẩm
- Số lượng
- Đơn giá
- Thành tiền
- Tổng tiền
- Trạng thái
- Lịch sử trạng thái nếu có

---

## 9. Quản lý đơn hàng

### 9.1 Xem danh sách đơn hàng

Nhân viên hoặc quản trị viên có quyền `order.view` được xem danh sách đơn hàng.

Hỗ trợ:

- Tìm kiếm theo mã đơn
- Tìm kiếm theo tên khách hàng
- Tìm kiếm theo số điện thoại
- Lọc theo trạng thái
- Lọc theo ngày đặt
- Sắp xếp mới nhất trước
- Phân trang

---

### 9.2 Cập nhật trạng thái đơn hàng

Quyền yêu cầu: `order.update_status`.

Trạng thái đề xuất:

| Mã trạng thái | Tên trạng thái |
|---|---|
| pending | Chờ xác nhận |
| processing | Đang xử lý |
| preparing | Đang chuẩn bị hàng |
| shipping | Đang giao hàng |
| completed | Hoàn thành |
| cancelled | Đã hủy |
| returned | Đổi/trả hàng |

Quy tắc:

- Khi chuyển từ `pending` sang `processing`, kiểm tra tồn kho
- Nếu tồn kho đủ, trừ tồn kho
- Nếu tồn kho không đủ, không cho xác nhận đơn
- Nếu hủy đơn đã trừ kho, phải cộng lại tồn kho
- Mỗi cập nhật trạng thái phải ghi lịch sử vào `order_status_logs`
- Thao tác trừ / cộng tồn kho phải dùng transaction

---

### 9.3 Hủy đơn hàng

Quyền yêu cầu:

- Khách hàng có thể hủy đơn của mình nếu đơn còn ở trạng thái `pending`
- Nhân viên hoặc quản trị viên cần quyền `order.cancel`

Quy tắc:

- Cần nhập lý do hủy
- Nếu đơn chưa trừ kho thì chỉ cập nhật trạng thái
- Nếu đơn đã trừ kho thì cộng lại tồn kho
- Không cho hủy đơn đã hoàn thành, trừ khi xử lý đổi/trả hàng
- Ghi log thao tác

---

## 10. Quản lý sản phẩm

### 10.1 Thêm sản phẩm

Quyền yêu cầu: `product.create`.

Dữ liệu:

- Tên sản phẩm
- Mã sản phẩm
- Danh mục
- Mô tả
- Giá bán
- Kích thước
- Chất liệu
- Màu sắc
- Tồn kho
- Hình ảnh
- Trạng thái hiển thị

Quy tắc:

- Tên không rỗng
- Giá bán >= 0
- Tồn kho >= 0
- Danh mục phải tồn tại
- Ảnh đúng định dạng

---

### 10.2 Cập nhật sản phẩm

Quyền yêu cầu: `product.update`.

Có thể sửa:

- Tên
- Giá
- Mô tả
- Kích thước
- Chất liệu
- Danh mục
- Tồn kho
- Hình ảnh
- Trạng thái

---

### 10.3 Xóa hoặc ẩn sản phẩm

Quyền yêu cầu: `product.delete`.

Quy tắc:

- Nếu sản phẩm chưa phát sinh đơn hàng, có thể soft delete
- Nếu sản phẩm đã phát sinh đơn hàng, chỉ được ẩn
- Không xóa cứng sản phẩm đã có giao dịch

---

### 10.4 Quản lý hình ảnh sản phẩm

Quyền yêu cầu: `product.manage_image`.

Chức năng:

- Upload nhiều ảnh
- Chọn ảnh đại diện
- Xóa ảnh không dùng
- Kiểm tra định dạng ảnh
- Giới hạn dung lượng ảnh

---

## 11. Quản lý danh mục

### 11.1 Thêm danh mục

Quyền yêu cầu: `category.create`.

Dữ liệu:

- Tên danh mục
- Mô tả
- Hình ảnh đại diện
- Trạng thái
- Danh mục cha nếu có

---

### 11.2 Cập nhật danh mục

Quyền yêu cầu: `category.update`.

Có thể sửa:

- Tên
- Mô tả
- Hình ảnh
- Trạng thái
- Danh mục cha

---

### 11.3 Xóa danh mục

Quyền yêu cầu: `category.delete`.

Quy tắc:

- Nếu danh mục chưa có sản phẩm thì có thể soft delete
- Nếu danh mục còn sản phẩm thì không cho xóa
- Có thể chuyển sản phẩm sang danh mục khác trước khi xóa

---

### 11.4 Xem danh sách danh mục

Quyền yêu cầu: `category.view`.

Hiển thị:

- Tên danh mục
- Mô tả
- Số sản phẩm
- Trạng thái
- Ngày tạo
- Ngày cập nhật

---

## 12. Quản lý khách hàng

Trong schema rút gọn, khách hàng được lưu trực tiếp trong `users`.

Quyền đề xuất:

- `customer.view`
- `customer.detail`
- `customer.lock`

Hiển thị:

- Họ tên
- Email
- Số điện thoại
- Địa chỉ
- Ngày đăng ký
- Trạng thái tài khoản
- Tổng số đơn hàng nếu có

Quy tắc:

- Tài khoản bị khóa không được đăng nhập
- Khi khóa cần nhập lý do
- Ghi nhận thay đổi trạng thái tài khoản

---

## 13. Quản lý người dùng nội bộ

### 13.1 Thêm người dùng

Quyền yêu cầu: `user.create`.

Dữ liệu:

- Họ tên
- Email
- Số điện thoại
- Mật khẩu
- Vai trò
- Trạng thái

Quy tắc:

- Email không trùng
- Mật khẩu phải hash
- Gán vai trò cho người dùng

---

### 13.2 Cập nhật người dùng

Quyền yêu cầu: `user.update`.

Có thể sửa:

- Họ tên
- Email
- Số điện thoại
- Vai trò
- Trạng thái

---

### 13.3 Khóa / mở khóa người dùng

Quyền yêu cầu: `user.lock`.

Quy tắc:

- Người bị khóa không được đăng nhập
- Không cho khóa quản trị viên duy nhất

---

## 14. Yêu cầu thiết kế nội thất

### 14.1 Gửi yêu cầu thiết kế

Khách hàng đăng nhập được gửi yêu cầu thiết kế.

Dữ liệu:

- Họ tên
- Số điện thoại
- Email
- Địa chỉ không gian
- Loại không gian
- Diện tích
- Chiều cao trần nếu có
- Số lượng phòng / khu vực
- Phong cách mong muốn
- Màu sắc chủ đạo
- Ngân sách dự kiến
- Thời gian hoàn thành mong muốn
- Yêu cầu cụ thể

Trạng thái ban đầu: `new`

---

### 14.2 Xem danh sách yêu cầu thiết kế

Quyền yêu cầu: `design_request.view`.

Hỗ trợ:

- Lọc theo trạng thái
- Lọc theo ngày gửi
- Lọc theo loại không gian
- Lọc theo ngân sách
- Tìm kiếm theo tên khách hàng
- Tìm kiếm theo số điện thoại
- Phân trang

---

### 14.3 Xem chi tiết yêu cầu thiết kế

Quyền yêu cầu: `design_request.detail`.

Hiển thị:

- Thông tin khách hàng
- Thông tin không gian
- Phong cách
- Ngân sách
- Yêu cầu cụ thể
- Trạng thái hiện tại

---

### 14.4 Cập nhật trạng thái yêu cầu thiết kế

Quyền yêu cầu: `design_request.update_status`.

Trạng thái đề xuất:

| Mã trạng thái | Tên trạng thái |
|---|---|
| new | Mới nhận |
| contacting | Đang liên hệ |
| surveyed | Đã khảo sát |
| designing | Đang thiết kế |
| sent_design | Đã gửi bản vẽ |
| approved | Khách đồng ý |
| constructing | Đang thi công |
| completed | Hoàn thành |
| cancelled | Đã hủy |

Quy tắc:

- Mỗi lần cập nhật phải lưu lại lịch sử trong hệ thống nghiệp vụ nếu có bổ sung sau này
- Nếu hủy yêu cầu thì cần nhập lý do

---

## 15. Phân quyền động

### 15.1 Mục tiêu

Hệ thống dùng mô hình:

`Người dùng -> Vai trò -> Quyền`

Một người dùng có thể có một hoặc nhiều vai trò.  
Một vai trò có thể có nhiều quyền.

### 15.2 Bảng dữ liệu phân quyền

- `users`
- `roles`
- `permissions`
- `role_user`
- `permission_role`

### 15.3 Kiểm tra quyền

Mỗi route quản trị phải kiểm tra:

1. Người dùng đã đăng nhập chưa
2. Người dùng có bị khóa không
3. Người dùng có vai trò nào
4. Vai trò đó có quyền cần thiết không
5. Có quyền thì cho truy cập
6. Không có quyền thì trả về 403

Không nên kiểm tra kiểu:

```php
if ($user->role == 'admin') {
    // cho phép
}
```

Nên kiểm tra kiểu:

```php
if ($user->hasPermission('product.create')) {
    // cho phép
}
```

---

## 16. Danh sách quyền đề xuất

| Nhóm | Mã quyền | Ý nghĩa |
|---|---|---|
| Sản phẩm | product.view | Xem sản phẩm |
| Sản phẩm | product.create | Thêm sản phẩm |
| Sản phẩm | product.update | Sửa sản phẩm |
| Sản phẩm | product.delete | Xóa/ẩn sản phẩm |
| Sản phẩm | product.manage_image | Quản lý hình ảnh sản phẩm |
| Danh mục | category.view | Xem danh mục |
| Danh mục | category.create | Thêm danh mục |
| Danh mục | category.update | Sửa danh mục |
| Danh mục | category.delete | Xóa danh mục |
| Đơn hàng | order.view | Xem đơn hàng |
| Đơn hàng | order.detail | Xem chi tiết đơn hàng |
| Đơn hàng | order.update_status | Cập nhật trạng thái |
| Đơn hàng | order.cancel | Hủy đơn hàng |
| Khách hàng | customer.view | Xem khách hàng |
| Khách hàng | customer.detail | Xem chi tiết khách hàng |
| Khách hàng | customer.lock | Khóa/mở khóa khách hàng |
| Người dùng | user.view | Xem người dùng |
| Người dùng | user.create | Thêm người dùng |
| Người dùng | user.update | Sửa người dùng |
| Người dùng | user.lock | Khóa/mở khóa người dùng |
| Vai trò | role.view | Xem vai trò |
| Vai trò | role.create | Thêm vai trò |
| Vai trò | role.update | Sửa vai trò |
| Vai trò | role.delete | Xóa vai trò |
| Quyền | permission.view | Xem quyền |
| Quyền | permission.assign | Gán quyền |
| Thiết kế | design_request.view | Xem yêu cầu thiết kế |
| Thiết kế | design_request.detail | Xem chi tiết yêu cầu |
| Thiết kế | design_request.update_status | Cập nhật trạng thái |
| Báo cáo | report.view | Xem báo cáo |
| Báo cáo | report.export | Xuất báo cáo |

---

## 17. Bảng cơ sở dữ liệu cơ bản

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

Nhóm yêu cầu thiết kế:

- design_requests

---

## 18. Quy tắc lập trình quan trọng

1. Không hard-code quyền trong controller.
2. Mọi route quản trị phải kiểm tra đăng nhập.
3. Mọi chức năng quản trị phải kiểm tra quyền.
4. Mật khẩu phải hash.
5. Dữ liệu đầu vào phải validate.
6. Không xóa cứng dữ liệu quan trọng.
7. Nên dùng soft delete cho dữ liệu quan trọng.
8. Đặt hàng, xác nhận đơn, hủy đơn nên dùng transaction nếu có thay đổi dữ liệu liên quan.
9. Giỏ hàng và đơn hàng phải xử lý đúng số lượng.
10. Giao diện quản trị chỉ hiển thị menu theo quyền.
11. Không cho khách hàng xem dữ liệu của khách khác.
12. Không cho nhân viên tự cấp quyền cho chính mình.

