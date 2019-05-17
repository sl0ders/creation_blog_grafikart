<?php
require dirname(__DIR__) . '/vendor/autoload.php';
//  ONT UTILISE FAKER POUR GENERER DES DONNEES ALEATOIRE  //
$faker = Faker\Factory::create('fr_FR');

$app = new App\App(true);
$pdo = $app->getPDO();

// ONT VIDE COMPLETEMENT LA BASE DE DONNEES
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

// ET ON UTILISE DES BOUCLE POUR INSERER DES CHOSES //
// d'abors on insert les données de base //
// et ensuite on insert les liaison pour lier les données entre elle //
for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name ='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->date} {$faker->time}', content='{$faker->paragraphs(rand(3,15), true)}'");
    $posts[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name ='{$faker->sentence(3)}', slug='{$faker->slug}'");
    $categories[] = $pdo->lastInsertId();
}

foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}
$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");
