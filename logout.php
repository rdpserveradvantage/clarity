<? session_start();
session_destroy();?>

<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>        
    </head>
    <body>

<script>

                    Swal.fire({
                        title: "Logout Successful",
                        text: "Redirecting...",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                        didClose: () => {
                            window.location.href = 'pages/auth/login.php';
                        },
                    });

</script>        
    </body>
</html>