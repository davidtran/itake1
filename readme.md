**Welcome**
Chúc mừng bạn là người được chọn để tham gia dự án iTake.me Đây là một website thương mại điện tử cho phép rao vặt theo mô hình mạng xã hội.
Thành viên trong team:
Trần Khánh Nam
Nguyễn Tuấn
Nguyễn Vũ Văn Khoa
--Danh sách sẽ được bổ sung sau ^^

**Hướng dẫn deploy**
Sau khi clone source về.
Vô common/config/env sẽ thấy có 3 file
private: dành cho chạy local
staging
prod: dành cho live

Tuỳ theo loại server mà chỉnh file tương ứng cho phù hợp. Các thông tin gồm: db, email, facebook...

Chạy php runpostdeploy private/staging/prod
Chọn 1 trong 3 loại để cài đặt môi trường
Lưu ý: Không chỉnh sửa gì ở các file private/staging/prod. Nếu muốn chỉnh sửa riêng thì chỉnh sửa các file *-local

*custom config*
sửa lại file param-local.php và main-local.php trong thư mục config

*solr*
CD vào solr để chạy solr: java -jar start.jar
Import dữ liệu vào solr:
cd ra thư mục ngoài cùng, chạy php yiic solr importExistProduct

*restart solr*
dùng script restartsolr.sh 

*cron job*
php yiic email sendQueueEmail - 5 phút
php yiic email weeklyAnalytic - 1 tuần, vào tối t6, lúc 24h đêm
php yiic solr importExistProduct - mỗi 5 tiếng