# ONLINE STORE


## info
Sistem ini dibangun menggunakan [Yii Framework](https://yiiframework.com).
## permasalahan
Jumlah Stok sering salah dilaporkan, bahkan stok sering menjadi negatif itu dikarenakan :
1. pada saat pembeli melihat rincian produk, stok yang ditampilkan belum dikurangi dengan jumlah (qty) yang dipesan oleh orang lain terhadap produk yang sama.
2. Pelanggan bisa melakukan checkout bersamaan / Race Condition (terutama pada saat event) karena jumlah stok yang dilihat oleh semua pelanggan dianggap masih ada.

## solusi
1. Menampilkan stok tersedia yang dihitung dari stok asli dikurangi stok dipesan (checkout yang belum dibayar).
2. Pada saat checkout, data akan ditampung sistem Queue (dalam kasus ini, menggunakan extension yii-queue). sehingga apabila submit berbarengan, status tetap 0 = Pending akan mengantri untuk melihat stok tersedia dan update stok dipesan sebelum status checkout aktif. Apabila stok tersedia kurang dari qty yang akan dipesan, maka status checkout menjadi rejected (by system).

## cara menjalankan aplikasi
1. clone / download app ini 
2. jalankan ```composer install```
2. jalankan ```docker-compose up -d --build```
3. Masuk ke container evrms-yii2 dan jalankan ```php yii migrate```
4. buka aplikasi menggunakan API Development (Postman)
5. Dokumentasi API : 

#### lihat semua produk
```http
GET /product
```
> Response
```javascript
[
    {
        "id": 1,
        "merchant_id": 2,
        "name": "product-0",
        "description": "eum praesentium maiores placeat beatae",
        "price": 5000,
        "stock": 16,
        "ordered_stock": 0
    },
    {
        "id": 2,
        "merchant_id": 5,
        "name": "product-1",
        "description": "laboriosam ad quos exercitationem facilis",
        "price": 5000,
        "stock": 0,
        "ordered_stock": 0
    }
]
```
#### List order
```http
GET /order
```
> Response
```javascript
[
    {
        "id": "9",
        "customer_id": "1",
        "date": "2021-09-20 15:35:25",
        "status": "1",
        "status_desc": "Checkout. Please do payment."
    },
    {
        "id": "10",
        "customer_id": "1",
        "date": "2021-09-20 15:40:44",
        "status": "1",
        "status_desc": "Checkout. Please do payment."
    },
    {
        "id": "11",
        "customer_id": "1",
        "date": "2021-09-20 15:58:15",
        "status": "0",
        "status_desc": "On Checking Stock"
    },
    {
        "id": "12",
        "customer_id": "1",
        "date": "2021-09-20 15:58:40",
        "status": "0",
        "status_desc": "On Checking Stock"
    }
]
```

#### Order Baru
```http
POST /order/new
```
> Payload
```javascript
{
    "customer_id": 1,
    "product_list": [
        {
            "product_id": 24,
            "quantity": 1
        },
        {
            "product_id": 25,
            "quantity": 1
        },
        {
            "product_id": 26,
            "quantity": 1
        }
    ]
}
```
> Response
```javascript
{
    "order": {
        "customer_id": 1,
        "date": "2021-09-20 15:58:40",
        "status": 0,
        "status_desc": "On Checking Stock",
        "id": 12
    },
    "queue_id": "20"
}
```

#### bayar checkout
```http
POST /order/pay
```
> Payload
```javascript
{"order_id": 2}
```
> Response
```javascript
{
    "id": 2,
    "customer_id": 1,
    "date": "2021-09-20 11:17:46",
    "status": 2,
    "status_desc": "Order has been paid. Transaction is done."
}
```


> kekurangan : cron untuk menjalankan ```queue/run``` masih belum berhasil. jadi untuk mencoba logic transaksinya berjalan, jalankan manual ```php yii queue/run``` di dalam container **evrms-yii**