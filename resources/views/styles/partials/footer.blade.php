<style>
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 8;
        border-top: 1px solid #ddd;
        padding: 5px 0;
    }

    .footer p {
        display: inline-block;
        margin: 0 10px;
    }
</style>
<div class="footer lato-regular ">
    <p>{{ $name }}</p>
    <p>{{ $uuid }}</p>
    <p>{{ $date }}</p>
</div>
