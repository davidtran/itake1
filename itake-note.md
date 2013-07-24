**Hướng dẫn deploy**

Sau khi clone source về.

Vô common/config/env sẽ thấy có 3 file
private: dành cho chạy local
staging
prod: dành cho live

Tuỳ theo loại server mà chỉnh file tương ứng cho phù hợp. Các thông tin gồm: db, email, facebook...

Chạy php runpostdeploy private/staging/prod
Chọn 1 trong 3 loại để cài đặt môi trường

CD vào solr để chạy solr: java -jar start.jar
Import dữ liệu vào solr:
cd ra thư mục ngoài cùng, chạy php yiic solr importExistProduct
