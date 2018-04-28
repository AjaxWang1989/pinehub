# pinehub-api
## 部署
### nginx配置
### php pool配置（fpm）
### fpm负载均衡

## 客户端http请求需要注意驶向
    - API请求时http header accept application/vnd.pinehub.(版本号根据后台服务器接口版本号一致由服务器定义)+json
    -   json web token api// send the refreshed token back to the client
        $response->headers->set('Authorization', 'Bearer '.$newToken);
        客户端 jwt http请求header设置authoriztion bearer token
        
        
        ./configure \
        --prefix=/usr/local/php/72 \
        --with-config-file-path=/usr/local/php/72/etc \
        --with-config-file-scan-dir=/usr/local/php/72/etc/php.d \
        --with-libxml-dir \
        --with-libedit \
        --with-tidy \
        --with-pcre-jit \
        --with-xmlrpc \
        --with-openssl \
        --with-mhash \
        --with-kerberos \
        --with-pcre-regex \
        --with-sqlite3 \
        --with-zlib \
        --with-iconv \
        --with-bz2 \
        --with-curl \
        --with-cdb \
        --with-pcre-dir \
        --with-gd \
        --with-openssl-dir \
        --with-jpeg-dir \
        --with-png-dir \
        --with-zlib-dir \
        --with-freetype-dir \
        --with-gettext \
        --with-gmp \
        --with-mhash \
        --with-libmbfl \
        --with-onig \
        --with-mysqli=mysqlnd \
        --with-pdo-mysql=mysqlnd \
        --with-zlib-dir \
        --with-pdo-sqlite \
        --with-readline \
        --with-pear \
        --with-xsl \
        --with-libxml-dir \
        --enable-mysqlnd \
        --enable-short-tags \
        --enable-static \
        --enable-intl \
        --enable-fpm \
        --enable-cli \
        --enable-ctype \
        --enable-inline-optimization \
        --enable-shared \
        --enable-soap \
        --enable-pcntl \
        --enable-bcmath \
        --enable-calendar \
        --enable-dom \
        --enable-exif \
        --enable-filter \
        --enable-ftp \
        --enable-gd-jis-conv \
        --enable-json \
        --enable-mbstring \
        --enable-mbregex \
        --enable-mbregex-backtrack \
        --enable-pdo \
        --enable-zip \
        --enable-session \
        --enable-shmop \
        --enable-simplexml \
        --enable-sockets \
        --enable-sysvmsg \
        --enable-sysvsem \
        --enable-sysvshm \
        --enable-wddx \
        --enable-xml \
        --enable-mysqlnd-compression-support \
        --enable-opcache \
        --enable-fileinfo \
        --disable-debug \
        --disable-rpath \
        --enable-sockets \
        --with-libmemcached-dir\
        
