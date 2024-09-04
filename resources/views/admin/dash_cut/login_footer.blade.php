<!-- <div class="mt-5 text-center" style="color:black!important">
                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> WVS Crafted with <i class="mdi mdi-heart text-danger"></i> by Code of Dolphins.</p>
                        © <script>document.write(new Date().getFullYear())</script> Supersathi <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://codeofdolphins.com/" style="color:#102d8b;font-weight: 500;">Code of Dolphins.</a></span>
                    </div> -->


                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('dashboard_assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('dashboard_assets/js/app.js') }}"></script>
    <script>
        function togglePassword(toggleIcon) {
            const passwordField = toggleIcon.previousElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                toggleIcon.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>

</html>