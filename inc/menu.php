<?php
				if (isset($_GET['page'])) {
					$hal = $_GET['page'];

					switch ($hal) {
							//Klik Halaman Home Pengguna
						case 'admin':
							include "pages/tampil.php";
							break;
						

							//Pengguna
						case 'MyApp/data_pengguna':
							include "pages/admin/data_pengguna.php";
							break;
						case 'MyApp/add_pengguna':
							include "pages/admin/add_pengguna.php";
							break;
						


							//agt
						case 'MyApp/data_agt':
							include "pages/admin/data_pengguna.php";
							break;
						case 'MyApp/add_agt':
							include "pages/admin/add_pengguna.php";
							break;
						


							//buku
						case 'MyApp/data_buku':
							include "pages/buku/data_buku.php";
							break;
						case 'MyApp/add_buku':
							include "pages/buku/add_buku.php";
							break;


							// Setting
case 'MyApp/setting_profil':
    include "pages/setting/setting.php";
    break;
case 'MyApp/setting_system':
    include "pages/setting/proses_setting.php";
    break;

						
					

							//default
						default:
							echo "<center><br><br><br><br><br><br><br><br><br>
				  <h1> Halaman tidak ditemukan !</h1></center>";
							break;
					}
				} else {
					// Auto Halaman Home Pengguna
					if ($data_level == "Administrator") {
						include "pages/tampil.php";
					} 
				}
				?>