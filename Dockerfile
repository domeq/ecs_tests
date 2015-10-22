FROM tutum/apache-php
RUN rm -fr /app
COPY . /app
WORKDIR /app
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install
