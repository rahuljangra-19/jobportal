<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Rounder</title>
<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/style-new.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">


<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.24.0/contents.min.css" integrity="sha512-HK3G0WJTxeYhsh/hzS/1NDmqw1uZplDy2w2Z60xHPTytEKEpSSXF9DsXytkUNLh7AyPeBvyVSpz4+kRCxTDYqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
    integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .d-none {
        display: none;
    }

    .radio.inline.mb-4 {
        margin-bottom: 15px;
    }

    .loader-img {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        aspect-ratio: 3 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .15);
    }

    div.card-wrap {
        position: relative;
    }

    .loader-img img {
        width: 100%;
        max-width: 50px;
    }

    .buttons-wrap {
        display: flex;
        justify-content: space-evenly;
    }

    a.apply-btn {
        width: 100%;
        height: 100% !important;
        position: absolute;
        z-index: 99;
        opacity: 0;
        top:0px;
    }
</style>
