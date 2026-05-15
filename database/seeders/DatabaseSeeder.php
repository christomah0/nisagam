<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@nisagam.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Jean Rakoto',
            'email' => 'jean@nisagam.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Marie Rabe',
            'email' => 'marie@nisagam.com',
            'password' => Hash::make('password'),
        ]);

        // Categories
        $alimentaire = Category::create(['name' => 'Alimentaire', 'description' => 'Produits alimentaires et boissons']);
        $electronique = Category::create(['name' => 'Électronique', 'description' => 'Appareils et accessoires électroniques']);
        $fournitures = Category::create(['name' => 'Fournitures de bureau', 'description' => 'Papeterie, stylos, classeurs, etc.']);
        $hygiene = Category::create(['name' => 'Hygiène & Entretien', 'description' => 'Produits de nettoyage et d\'hygiène']);
        $construction = Category::create(['name' => 'Matériaux de construction', 'description' => 'Ciment, fer, bois, peinture']);
        $vestimentaire = Category::create(['name' => 'Vestimentaire', 'description' => 'Vêtements et textiles']);

        // Suppliers
        $supplierSoa = Supplier::create([
            'name' => 'Soa Distribution',
            'email' => 'contact@soadist.mg',
            'phone' => '+261 34 12 345 67',
            'address' => 'Lot IVG 123, Analakely, Antananarivo',
        ]);

        $supplierStar = Supplier::create([
            'name' => 'Star Brasseries',
            'email' => 'ventes@star.mg',
            'phone' => '+261 32 11 222 33',
            'address' => 'Zone industrielle Antsirabe',
        ]);

        $supplierTech = Supplier::create([
            'name' => 'MadaTech Import',
            'email' => 'info@madatech.mg',
            'phone' => '+261 33 44 555 66',
            'address' => 'Immeuble Galaxy, Ankorondrano, Antananarivo',
        ]);

        $supplierPapier = Supplier::create([
            'name' => 'Papeterie Centrale',
            'email' => 'commande@papcentrale.mg',
            'phone' => '+261 34 77 888 99',
            'address' => '12 Rue du Commerce, Analakely',
        ]);

        $supplierClean = Supplier::create([
            'name' => 'ProClean Madagascar',
            'email' => 'info@proclean.mg',
            'phone' => '+261 32 55 666 77',
            'address' => 'Lot 45, Tanjombato',
        ]);

        $supplierBtp = Supplier::create([
            'name' => 'BTP Matériaux',
            'email' => 'vente@btpmat.mg',
            'phone' => '+261 34 99 000 11',
            'address' => 'Route d\'Ivato, Talatamaty',
        ]);

        // Products - Alimentaire
        $riz = Product::create(['name' => 'Riz blanc (sac 50kg)', 'description' => 'Riz blanc de qualité supérieure', 'price' => 120000, 'quantity' => 45, 'stock_alert' => 10, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierSoa->id]);
        $huile = Product::create(['name' => 'Huile de soja (bidon 20L)', 'description' => 'Huile végétale pour cuisson', 'price' => 85000, 'quantity' => 30, 'stock_alert' => 8, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierSoa->id]);
        $sucre = Product::create(['name' => 'Sucre (sac 25kg)', 'description' => 'Sucre blanc raffiné', 'price' => 62000, 'quantity' => 20, 'stock_alert' => 5, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierSoa->id]);
        $farine = Product::create(['name' => 'Farine de blé (sac 25kg)', 'description' => 'Farine type 55', 'price' => 48000, 'quantity' => 3, 'stock_alert' => 5, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierSoa->id]);
        $eau = Product::create(['name' => 'Eau minérale (pack 6x1.5L)', 'description' => 'Eau de source naturelle', 'price' => 8500, 'quantity' => 60, 'stock_alert' => 15, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierStar->id]);
        $the = Product::create(['name' => 'Thé vert (boîte 100 sachets)', 'description' => 'Thé vert importé', 'price' => 15000, 'quantity' => 2, 'stock_alert' => 5, 'category_id' => $alimentaire->id, 'supplier_id' => $supplierSoa->id]);

        // Products - Électronique
        $laptop = Product::create(['name' => 'Laptop HP 15 pouces', 'description' => 'Intel i5, 8GB RAM, 256GB SSD', 'price' => 1850000, 'quantity' => 8, 'stock_alert' => 3, 'category_id' => $electronique->id, 'supplier_id' => $supplierTech->id]);
        $imprimante = Product::create(['name' => 'Imprimante Canon PIXMA', 'description' => 'Imprimante multifonction jet d\'encre', 'price' => 450000, 'quantity' => 5, 'stock_alert' => 2, 'category_id' => $electronique->id, 'supplier_id' => $supplierTech->id]);
        $cable = Product::create(['name' => 'Câble HDMI 2m', 'description' => 'Câble HDMI haute vitesse', 'price' => 18000, 'quantity' => 25, 'stock_alert' => 5, 'category_id' => $electronique->id, 'supplier_id' => $supplierTech->id]);
        $souris = Product::create(['name' => 'Souris sans fil Logitech', 'description' => 'Souris ergonomique wireless', 'price' => 45000, 'quantity' => 1, 'stock_alert' => 3, 'category_id' => $electronique->id, 'supplier_id' => $supplierTech->id]);

        // Products - Fournitures de bureau
        $papier = Product::create(['name' => 'Ramette papier A4 (500 feuilles)', 'description' => 'Papier blanc 80g/m²', 'price' => 22000, 'quantity' => 40, 'stock_alert' => 10, 'category_id' => $fournitures->id, 'supplier_id' => $supplierPapier->id]);
        $stylo = Product::create(['name' => 'Stylo BIC bleu (boîte 50)', 'description' => 'Stylo à bille pointe moyenne', 'price' => 35000, 'quantity' => 15, 'stock_alert' => 5, 'category_id' => $fournitures->id, 'supplier_id' => $supplierPapier->id]);
        $classeur = Product::create(['name' => 'Classeur A4 grand format', 'description' => 'Classeur à levier dos 70mm', 'price' => 12000, 'quantity' => 0, 'stock_alert' => 5, 'category_id' => $fournitures->id, 'supplier_id' => $supplierPapier->id]);

        // Products - Hygiène
        $savon = Product::create(['name' => 'Savon liquide (bidon 5L)', 'description' => 'Savon antibactérien pour les mains', 'price' => 28000, 'quantity' => 12, 'stock_alert' => 4, 'category_id' => $hygiene->id, 'supplier_id' => $supplierClean->id]);
        $javel = Product::create(['name' => 'Eau de Javel (bidon 5L)', 'description' => 'Désinfectant multi-surfaces', 'price' => 15000, 'quantity' => 18, 'stock_alert' => 5, 'category_id' => $hygiene->id, 'supplier_id' => $supplierClean->id]);
        $balai = Product::create(['name' => 'Balai serpillère complet', 'description' => 'Balai avec seau essoreur', 'price' => 35000, 'quantity' => 4, 'stock_alert' => 2, 'category_id' => $hygiene->id, 'supplier_id' => $supplierClean->id]);

        // Products - Construction
        $ciment = Product::create(['name' => 'Ciment COLAS (sac 50kg)', 'description' => 'Ciment Portland CEM II', 'price' => 38000, 'quantity' => 100, 'stock_alert' => 20, 'category_id' => $construction->id, 'supplier_id' => $supplierBtp->id]);
        $fer = Product::create(['name' => 'Fer à béton Ø12 (barre 12m)', 'description' => 'Acier haute adhérence', 'price' => 28000, 'quantity' => 50, 'stock_alert' => 15, 'category_id' => $construction->id, 'supplier_id' => $supplierBtp->id]);
        $peinture = Product::create(['name' => 'Peinture blanche (seau 15L)', 'description' => 'Peinture acrylique intérieur/extérieur', 'price' => 95000, 'quantity' => 2, 'stock_alert' => 3, 'category_id' => $construction->id, 'supplier_id' => $supplierBtp->id]);

        // Transactions - mix of entries and exits
        $now = now();

        // Stock entries (achats)
        Transaction::create(['type' => 'entree', 'product_id' => $riz->id, 'quantity' => 50, 'unit_price' => 110000, 'note' => 'Réapprovisionnement mensuel', 'created_at' => $now->copy()->subDays(25)]);
        Transaction::create(['type' => 'entree', 'product_id' => $huile->id, 'quantity' => 20, 'unit_price' => 82000, 'note' => 'Commande fournisseur Soa', 'created_at' => $now->copy()->subDays(22)]);
        Transaction::create(['type' => 'entree', 'product_id' => $laptop->id, 'quantity' => 10, 'unit_price' => 1750000, 'note' => 'Lot importé MadaTech', 'created_at' => $now->copy()->subDays(20)]);
        Transaction::create(['type' => 'entree', 'product_id' => $ciment->id, 'quantity' => 120, 'unit_price' => 35000, 'note' => 'Commande chantier Ivato', 'created_at' => $now->copy()->subDays(18)]);
        Transaction::create(['type' => 'entree', 'product_id' => $papier->id, 'quantity' => 50, 'unit_price' => 20000, 'note' => 'Stock trimestriel bureau', 'created_at' => $now->copy()->subDays(15)]);
        Transaction::create(['type' => 'entree', 'product_id' => $fer->id, 'quantity' => 60, 'unit_price' => 26000, 'note' => 'Livraison BTP Matériaux', 'created_at' => $now->copy()->subDays(14)]);
        Transaction::create(['type' => 'entree', 'product_id' => $savon->id, 'quantity' => 15, 'unit_price' => 26000, 'note' => 'Réapprovisionnement hygiène', 'created_at' => $now->copy()->subDays(12)]);
        Transaction::create(['type' => 'entree', 'product_id' => $eau->id, 'quantity' => 80, 'unit_price' => 7500, 'note' => 'Stock boissons', 'created_at' => $now->copy()->subDays(10)]);

        // Stock exits (ventes/utilisations)
        Transaction::create(['type' => 'sortie', 'product_id' => $riz->id, 'quantity' => 5, 'unit_price' => 120000, 'note' => 'Vente client Ambohimanga', 'created_at' => $now->copy()->subDays(19)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $laptop->id, 'quantity' => 2, 'unit_price' => 1850000, 'note' => 'Vente entreprise Socimex', 'created_at' => $now->copy()->subDays(16)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $ciment->id, 'quantity' => 20, 'unit_price' => 38000, 'note' => 'Livraison chantier Ambatondrazaka', 'created_at' => $now->copy()->subDays(13)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $papier->id, 'quantity' => 10, 'unit_price' => 22000, 'note' => 'Usage interne bureau', 'created_at' => $now->copy()->subDays(11)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $fer->id, 'quantity' => 10, 'unit_price' => 28000, 'note' => 'Chantier Antsirabe', 'created_at' => $now->copy()->subDays(9)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $eau->id, 'quantity' => 20, 'unit_price' => 8500, 'note' => 'Événement entreprise', 'created_at' => $now->copy()->subDays(7)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $sucre->id, 'quantity' => 5, 'unit_price' => 62000, 'note' => 'Vente détail', 'created_at' => $now->copy()->subDays(5)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $savon->id, 'quantity' => 3, 'unit_price' => 28000, 'note' => 'Distribution bureaux', 'created_at' => $now->copy()->subDays(3)]);

        // Recent transactions
        Transaction::create(['type' => 'entree', 'product_id' => $stylo->id, 'quantity' => 20, 'unit_price' => 32000, 'note' => 'Commande Papeterie Centrale', 'created_at' => $now->copy()->subDays(2)]);
        Transaction::create(['type' => 'sortie', 'product_id' => $imprimante->id, 'quantity' => 1, 'unit_price' => 450000, 'note' => 'Vente client particulier', 'created_at' => $now->copy()->subDay()]);
        Transaction::create(['type' => 'entree', 'product_id' => $javel->id, 'quantity' => 10, 'unit_price' => 14000, 'note' => 'Réapprovisionnement ProClean', 'created_at' => $now]);
    }
}
