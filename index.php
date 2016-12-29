<!DOCTYPE html>
<html lang="tr-TR">
<head>
	<title>Sihirli Kareler</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/reset.css">
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div class="site">
		<div class="container">
			<h1>Sihirli Kareler</h1>
			<form action="" method="get">
				<input type="text" name="n" placeholder="Bir sayı girip enter'a basın" value="<?php echo (isset($_GET['n'])) ? $_GET['n'] : ""; ?>">
			</form>
			<?php 
				// GET methodunun parametresinde n degiskeni varsa ve tek sayi ise tablomuzu gosterelim
				if (isset($_GET['n']) && $_GET['n'] % 2 != '0' && $_GET['n'] >= 3) {
				?>
				<table>
					<?php
						//error_reporting(0);
						$n = $_GET['n'];
						$nkare = $n * $n;
						$sihirlitoplam = $n * ($nkare+1) / 2;

						$tumsayilar = array();
						$satir = array();
						for ($i=0; $i <= $nkare; $i++) {
							if ($i != 0) {
								if ($i % $n == 0){
									$tumsayilar[] = $satir;
									$satir = '';
								}
							}
							// Once tum satirlara 0 degerini yazdiralim
							$satir[] = 0;
						}

						$satirIndex = 0;
						$sutunIndex = 0;
						$sayi = 0;

						// Ikinci bir for ile 0 degerlerini degistirmeye basliyoruz
						for ($i=0; $i < $nkare-1; $i++) {
							// 1. kural!
							if ($i == 0) {
								$tumsayilar[0][(($n + 1) / 2) - 1] = 1;
								$sayi = 1;
								$satirIndex = 0;
								$sutunIndex = (($n + 1) / 2) - 1;
							}
							
							// 2. kural! - Sag ustte yer varsa ve oradaki kutu boşsa (0sa)
							if ($satirIndex != 0 && $sutunIndex < $n-1 && $tumsayilar[$satirIndex-1][$sutunIndex+1] == 0) {
								$sutunIndex++;
								$satirIndex--;
								$tumsayilar[$satirIndex][$sutunIndex] = $sayi + 1;
								$sayi++;
							}
							// Sag ustte yer yok
							else{
								// Sag ustte hangi sebeple yer yok?
								// En kosedeysek alttaki 2 sart ayni anda saglaniyor demektir. Bu sebeple 4. kural!
								if ($satirIndex == 0 && $sutunIndex == $n-1) {
									// Bir onceki sayinin altina yazacagiz, bakalim bos mu?
									if ($tumsayilar[$satirIndex+1][$sutunIndex] == 0) {
										$satirIndex++;
										$tumsayilar[$satirIndex][$sutunIndex] = $sayi + 1;
										$sayi = $tumsayilar[$satirIndex][$sutunIndex];
									}
								}
								// 0. satirdaysak, ustte yer yoktur. Bu sebeple 3. kural!
								elseif ($satirIndex == 0) {
									// 3. kural icin son satira gidiyoruz
									$sonsatir = $n-1;
									// Son satirin bir sag kolonu bossa devam edelim.
									if ($tumsayilar[$sonsatir][$sutunIndex+1] == 0) {
										$sutunIndex++;
										$tumsayilar[$sonsatir][$sutunIndex] = $sayi + 1;
										$sayi = $tumsayilar[$sonsatir][$sutunIndex];
										$satirIndex = $sonsatir;
									}
								}
								// En sagdaki kolondaysak 3. kuralin 2. maddesini uyguluyoruz
								elseif ($sutunIndex == $n-1) {
									// Bir ust satirin en soluna gidiyoruz
									// Icinde bi deger yoksa (0 ise) devam...
									if ($tumsayilar[$satirIndex-1][0] == 0) {
										$sutunIndex = 0;
										$satirIndex--;
										$tumsayilar[$satirIndex][0] = $sayi + 1;
										$sayi = $tumsayilar[$satirIndex][0];
									}
								}
								// 0. satirda degiliz, sagda da yer var ancak degeri 0 degil, yani dolu
								// 4. kural! - Bir onceki sayinin altina yazmamiz gerekiyor
								else{
									// Bir onceki sayinin altina yazacagiz, bakalim bos mu?
									if ($tumsayilar[$satirIndex+1][$sutunIndex] == 0) {
										$satirIndex++;
										$tumsayilar[$satirIndex][$sutunIndex] = $sayi + 1;
										$sayi = $tumsayilar[$satirIndex][$sutunIndex];
									}
								}	
							}
						}

						// Satirlari olusturuyoruz
						foreach ($tumsayilar as $satir) {
							?>
							<tr>
								<?php
								foreach ($satir as $sutun) {
									?>
									<td><?php echo $sutun; ?></td>
									<?php
								}
								?>
							</tr>
							<?php
						}
					?>
				</table>
				<?php
				}
				else{
					?>
					<p>Lütfen 3 ya da 3'ten büyük bir tek sayı girin!</p>
					<?php
				}
			?>
		</div>
	</div>
</body>
</html>