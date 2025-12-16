<?php

namespace Database\Seeders;

use App\Models\Constituency;
use Illuminate\Database\Seeder;

class ConstituenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds all 290 constituencies in Kenya organized by county
     */
    public function run(): void
    {
        $constituencies = [
            // Baringo County
            ['name' => 'Baringo Central', 'county' => 'Baringo'],
            ['name' => 'Baringo North', 'county' => 'Baringo'],
            ['name' => 'Baringo South', 'county' => 'Baringo'],
            ['name' => 'Eldama Ravine', 'county' => 'Baringo'],
            ['name' => 'Mogotio', 'county' => 'Baringo'],
            ['name' => 'Tiaty', 'county' => 'Baringo'],

            // Bomet County
            ['name' => 'Bomet Central', 'county' => 'Bomet'],
            ['name' => 'Bomet East', 'county' => 'Bomet'],
            ['name' => 'Chepalungu', 'county' => 'Bomet'],
            ['name' => 'Konoin', 'county' => 'Bomet'],
            ['name' => 'Sotik', 'county' => 'Bomet'],

            // Bungoma County
            ['name' => 'Bumula', 'county' => 'Bungoma'],
            ['name' => 'Kabuchai', 'county' => 'Bungoma'],
            ['name' => 'Kanduyi', 'county' => 'Bungoma'],
            ['name' => 'Kimilili', 'county' => 'Bungoma'],
            ['name' => 'Mt Elgon', 'county' => 'Bungoma'],
            ['name' => 'Sirisia', 'county' => 'Bungoma'],
            ['name' => 'Tongaren', 'county' => 'Bungoma'],
            ['name' => 'Webuye East', 'county' => 'Bungoma'],
            ['name' => 'Webuye West', 'county' => 'Bungoma'],

            // Busia County
            ['name' => 'Budalangi', 'county' => 'Busia'],
            ['name' => 'Butula', 'county' => 'Busia'],
            ['name' => 'Funyula', 'county' => 'Busia'],
            ['name' => 'Nambale', 'county' => 'Busia'],
            ['name' => 'Teso North', 'county' => 'Busia'],
            ['name' => 'Teso South', 'county' => 'Busia'],
            ['name' => 'Samia', 'county' => 'Busia'],

            // Elgeyo Marakwet County
            ['name' => 'Keiyo North', 'county' => 'Elgeyo Marakwet'],
            ['name' => 'Keiyo South', 'county' => 'Elgeyo Marakwet'],
            ['name' => 'Marakwet East', 'county' => 'Elgeyo Marakwet'],
            ['name' => 'Marakwet West', 'county' => 'Elgeyo Marakwet'],

            // Embu County
            ['name' => 'Manyatta', 'county' => 'Embu'],
            ['name' => 'Mbeere North', 'county' => 'Embu'],
            ['name' => 'Mbeere South', 'county' => 'Embu'],
            ['name' => 'Runyenjes', 'county' => 'Embu'],

            // Garissa County
            ['name' => 'Dadaab', 'county' => 'Garissa'],
            ['name' => 'Fafi', 'county' => 'Garissa'],
            ['name' => 'Garissa Township', 'county' => 'Garissa'],
            ['name' => 'Hulugho', 'county' => 'Garissa'],
            ['name' => 'Ijara', 'county' => 'Garissa'],
            ['name' => 'Lagdera', 'county' => 'Garissa'],
            ['name' => 'Balambala', 'county' => 'Garissa'],

            // Homa Bay County
            ['name' => 'Homabay Town', 'county' => 'Homa Bay'],
            ['name' => 'Kabondo Kasipul', 'county' => 'Homa Bay'],
            ['name' => 'Karachuonyo', 'county' => 'Homa Bay'],
            ['name' => 'Kasipul', 'county' => 'Homa Bay'],
            ['name' => 'Mbita', 'county' => 'Homa Bay'],
            ['name' => 'Ndhiwa', 'county' => 'Homa Bay'],
            ['name' => 'Rangwe', 'county' => 'Homa Bay'],
            ['name' => 'Suba', 'county' => 'Homa Bay'],

            // Isiolo County
            ['name' => 'Isiolo North', 'county' => 'Isiolo'],
            ['name' => 'Isiolo South', 'county' => 'Isiolo'],

            // Kajiado County
            ['name' => 'Kajiado Central', 'county' => 'Kajiado'],
            ['name' => 'Kajiado East', 'county' => 'Kajiado'],
            ['name' => 'Kajiado North', 'county' => 'Kajiado'],
            ['name' => 'Kajiado South', 'county' => 'Kajiado'],
            ['name' => 'Kajiado West', 'county' => 'Kajiado'],

            // Kakamega County
            ['name' => 'Butere', 'county' => 'Kakamega'],
            ['name' => 'Ikolomani', 'county' => 'Kakamega'],
            ['name' => 'Khwisero', 'county' => 'Kakamega'],
            ['name' => 'Likuyani', 'county' => 'Kakamega'],
            ['name' => 'Lugari', 'county' => 'Kakamega'],
            ['name' => 'Lurambi', 'county' => 'Kakamega'],
            ['name' => 'Matungu', 'county' => 'Kakamega'],
            ['name' => 'Mumias East', 'county' => 'Kakamega'],
            ['name' => 'Mumias West', 'county' => 'Kakamega'],
            ['name' => 'Navakholo', 'county' => 'Kakamega'],
            ['name' => 'Shinyalu', 'county' => 'Kakamega'],
            ['name' => 'Malava', 'county' => 'Kakamega'],

            // Kericho County
            ['name' => 'Ainamoi', 'county' => 'Kericho'],
            ['name' => 'Belgut', 'county' => 'Kericho'],
            ['name' => 'Bureti', 'county' => 'Kericho'],
            ['name' => 'Kipkelion East', 'county' => 'Kericho'],
            ['name' => 'Kipkelion West', 'county' => 'Kericho'],
            ['name' => 'Soin Sigowet', 'county' => 'Kericho'],

            // Kiambu County
            ['name' => 'Gatundu North', 'county' => 'Kiambu'],
            ['name' => 'Gatundu South', 'county' => 'Kiambu'],
            ['name' => 'Githunguri', 'county' => 'Kiambu'],
            ['name' => 'Juja', 'county' => 'Kiambu'],
            ['name' => 'Kabete', 'county' => 'Kiambu'],
            ['name' => 'Kiambaa', 'county' => 'Kiambu'],
            ['name' => 'Kiambu', 'county' => 'Kiambu'],
            ['name' => 'Kikuyu', 'county' => 'Kiambu'],
            ['name' => 'Lari', 'county' => 'Kiambu'],
            ['name' => 'Limuru', 'county' => 'Kiambu'],
            ['name' => 'Ruiru', 'county' => 'Kiambu'],
            ['name' => 'Thika Town', 'county' => 'Kiambu'],

            // Kilifi County
            ['name' => 'Ganza', 'county' => 'Kilifi'],
            ['name' => 'Kaloleni', 'county' => 'Kilifi'],
            ['name' => 'Kilifi North', 'county' => 'Kilifi'],
            ['name' => 'Kilifi South', 'county' => 'Kilifi'],
            ['name' => 'Magarini', 'county' => 'Kilifi'],
            ['name' => 'Malindi', 'county' => 'Kilifi'],
            ['name' => 'Rabai', 'county' => 'Kilifi'],

            // Kirinyaga County
            ['name' => 'Gichugu', 'county' => 'Kirinyaga'],
            ['name' => 'Kirinyaga Central', 'county' => 'Kirinyaga'],
            ['name' => 'Mwea', 'county' => 'Kirinyaga'],
            ['name' => 'Ndia', 'county' => 'Kirinyaga'],

            // Kisii County
            ['name' => 'Bobasi', 'county' => 'Kisii'],
            ['name' => 'Bomachoge Borabu', 'county' => 'Kisii'],
            ['name' => 'Bomachoge Chache', 'county' => 'Kisii'],
            ['name' => 'Bonchari', 'county' => 'Kisii'],
            ['name' => 'Kitutu Chache North', 'county' => 'Kisii'],
            ['name' => 'Kitutu Chache South', 'county' => 'Kisii'],
            ['name' => 'Nyaribari Chache', 'county' => 'Kisii'],
            ['name' => 'Nyaribari Masaba', 'county' => 'Kisii'],
            ['name' => 'South Mugirango', 'county' => 'Kisii'],

            // Kisumu County
            ['name' => 'Kisumu Central', 'county' => 'Kisumu'],
            ['name' => 'Kisumu East', 'county' => 'Kisumu'],
            ['name' => 'Kisumu West', 'county' => 'Kisumu'],
            ['name' => 'Muhoroni', 'county' => 'Kisumu'],
            ['name' => 'Nyakach', 'county' => 'Kisumu'],
            ['name' => 'Nyando', 'county' => 'Kisumu'],
            ['name' => 'Seme', 'county' => 'Kisumu'],

            // Kitui County
            ['name' => 'Kitui Central', 'county' => 'Kitui'],
            ['name' => 'Kitui East', 'county' => 'Kitui'],
            ['name' => 'Kitui Rural', 'county' => 'Kitui'],
            ['name' => 'Kitui South', 'county' => 'Kitui'],
            ['name' => 'Kitui West', 'county' => 'Kitui'],
            ['name' => 'Mwingi Central', 'county' => 'Kitui'],
            ['name' => 'Mwingi North', 'county' => 'Kitui'],
            ['name' => 'Mwingi West', 'county' => 'Kitui'],

            // Kwale County
            ['name' => 'Kinango', 'county' => 'Kwale'],
            ['name' => 'Lunga Lunga', 'county' => 'Kwale'],
            ['name' => 'Matuga', 'county' => 'Kwale'],
            ['name' => 'Msambweni', 'county' => 'Kwale'],

            // Laikipia County
            ['name' => 'Laikipia East', 'county' => 'Laikipia'],
            ['name' => 'Laikipia North', 'county' => 'Laikipia'],
            ['name' => 'Laikipia West', 'county' => 'Laikipia'],

            // Lamu County
            ['name' => 'Lamu East', 'county' => 'Lamu'],
            ['name' => 'Lamu West', 'county' => 'Lamu'],

            // Machakos County
            ['name' => 'Kangundo', 'county' => 'Machakos'],
            ['name' => 'Kathiani', 'county' => 'Machakos'],
            ['name' => 'Machakos Town', 'county' => 'Machakos'],
            ['name' => 'Masinga', 'county' => 'Machakos'],
            ['name' => 'Matungulu', 'county' => 'Machakos'],
            ['name' => 'Mwala', 'county' => 'Machakos'],
            ['name' => 'Yatta', 'county' => 'Machakos'],
            ['name' => 'Mavoko', 'county' => 'Machakos'],

            // Makueni County
            ['name' => 'Kaiti', 'county' => 'Makueni'],
            ['name' => 'Kibwezi East', 'county' => 'Makueni'],
            ['name' => 'Kibwezi West', 'county' => 'Makueni'],
            ['name' => 'Kilome', 'county' => 'Makueni'],
            ['name' => 'Makueni', 'county' => 'Makueni'],
            ['name' => 'Mbooni', 'county' => 'Makueni'],

            // Mandera County
            ['name' => 'Banissa', 'county' => 'Mandera'],
            ['name' => 'Lafey', 'county' => 'Mandera'],
            ['name' => 'Mandera East', 'county' => 'Mandera'],
            ['name' => 'Mandera North', 'county' => 'Mandera'],
            ['name' => 'Mandera South', 'county' => 'Mandera'],
            ['name' => 'Mandera West', 'county' => 'Mandera'],

            // Marsabit County
            ['name' => 'Laisamis', 'county' => 'Marsabit'],
            ['name' => 'Moyale', 'county' => 'Marsabit'],
            ['name' => 'North Horr', 'county' => 'Marsabit'],
            ['name' => 'Saku', 'county' => 'Marsabit'],

            // Meru County
            ['name' => 'Buuri', 'county' => 'Meru'],
            ['name' => 'Igembe Central', 'county' => 'Meru'],
            ['name' => 'Igembe North', 'county' => 'Meru'],
            ['name' => 'Igembe South', 'county' => 'Meru'],
            ['name' => 'Imenti Central', 'county' => 'Meru'],
            ['name' => 'Imenti North', 'county' => 'Meru'],
            ['name' => 'Imenti South', 'county' => 'Meru'],
            ['name' => 'Tigania East', 'county' => 'Meru'],
            ['name' => 'Tigania West', 'county' => 'Meru'],

            // Migori County
            ['name' => 'Awendo', 'county' => 'Migori'],
            ['name' => 'Kuria East', 'county' => 'Migori'],
            ['name' => 'Kuria West', 'county' => 'Migori'],
            ['name' => 'Nyatike', 'county' => 'Migori'],
            ['name' => 'Rongo', 'county' => 'Migori'],
            ['name' => 'Suna East', 'county' => 'Migori'],
            ['name' => 'Suna West', 'county' => 'Migori'],
            ['name' => 'Uriri', 'county' => 'Migori'],

            // Mombasa County
            ['name' => 'Changamwe', 'county' => 'Mombasa'],
            ['name' => 'Jomvu', 'county' => 'Mombasa'],
            ['name' => 'Kisauni', 'county' => 'Mombasa'],
            ['name' => 'Likoni', 'county' => 'Mombasa'],
            ['name' => 'Mvita', 'county' => 'Mombasa'],
            ['name' => 'Nyali', 'county' => 'Mombasa'],

            // Murang\'a County
            ['name' => 'Gatanga', 'county' => 'Murang\'a'],
            ['name' => 'Kandara', 'county' => 'Murang\'a'],
            ['name' => 'Kangema', 'county' => 'Murang\'a'],
            ['name' => 'Kigumo', 'county' => 'Murang\'a'],
            ['name' => 'Kiharu', 'county' => 'Murang\'a'],
            ['name' => 'Mathioya', 'county' => 'Murang\'a'],
            ['name' => 'Maragwa', 'county' => 'Murang\'a'],

            // Nairobi County
            ['name' => 'Dagoretti North', 'county' => 'Nairobi'],
            ['name' => 'Dagoretti South', 'county' => 'Nairobi'],
            ['name' => 'Embakasi Central', 'county' => 'Nairobi'],
            ['name' => 'Embakasi East', 'county' => 'Nairobi'],
            ['name' => 'Embakasi North', 'county' => 'Nairobi'],
            ['name' => 'Embakasi South', 'county' => 'Nairobi'],
            ['name' => 'Embakasi West', 'county' => 'Nairobi'],
            ['name' => 'Kamukunji', 'county' => 'Nairobi'],
            ['name' => 'Kasarani', 'county' => 'Nairobi'],
            ['name' => 'Kibra', 'county' => 'Nairobi'],
            ['name' => 'Lang\'ata', 'county' => 'Nairobi'],
            ['name' => 'Makadara', 'county' => 'Nairobi'],
            ['name' => 'Mathare', 'county' => 'Nairobi'],
            ['name' => 'Roysambu', 'county' => 'Nairobi'],
            ['name' => 'Ruaraka', 'county' => 'Nairobi'],
            ['name' => 'Starehe', 'county' => 'Nairobi'],
            ['name' => 'Westlands', 'county' => 'Nairobi'],

            // Nakuru County
            ['name' => 'Bahati', 'county' => 'Nakuru'],
            ['name' => 'Gilgil', 'county' => 'Nakuru'],
            ['name' => 'Kuresoi North', 'county' => 'Nakuru'],
            ['name' => 'Kuresoi South', 'county' => 'Nakuru'],
            ['name' => 'Molo', 'county' => 'Nakuru'],
            ['name' => 'Naivasha', 'county' => 'Nakuru'],
            ['name' => 'Nakuru Town East', 'county' => 'Nakuru'],
            ['name' => 'Nakuru Town West', 'county' => 'Nakuru'],
            ['name' => 'Njoro', 'county' => 'Nakuru'],
            ['name' => 'Rongai', 'county' => 'Nakuru'],
            ['name' => 'Subukia', 'county' => 'Nakuru'],

            // Nandi County
            ['name' => 'Aldai', 'county' => 'Nandi'],
            ['name' => 'Chesumei', 'county' => 'Nandi'],
            ['name' => 'Emgwen', 'county' => 'Nandi'],
            ['name' => 'Mosop', 'county' => 'Nandi'],
            ['name' => 'Nandi Hills', 'county' => 'Nandi'],
            ['name' => 'Tinderet', 'county' => 'Nandi'],

            // Narok County
            ['name' => 'Narok East', 'county' => 'Narok'],
            ['name' => 'Narok North', 'county' => 'Narok'],
            ['name' => 'Narok South', 'county' => 'Narok'],
            ['name' => 'Narok West', 'county' => 'Narok'],
            ['name' => 'Emurua Dikirr', 'county' => 'Narok'],
            ['name' => 'Kilgoris', 'county' => 'Narok'],

            // Nyamira County
            ['name' => 'Borabu', 'county' => 'Nyamira'],
            ['name' => 'Kitutu Masaba', 'county' => 'Nyamira'],
            ['name' => 'North Mugirango', 'county' => 'Nyamira'],
            ['name' => 'West Mugirango', 'county' => 'Nyamira'],

            // Nyandarua County
            ['name' => 'Kinangop', 'county' => 'Nyandarua'],
            ['name' => 'Kipipiri', 'county' => 'Nyandarua'],
            ['name' => 'Ndaragwa', 'county' => 'Nyandarua'],
            ['name' => 'Ol Jorok', 'county' => 'Nyandarua'],
            ['name' => 'Ol Kalou', 'county' => 'Nyandarua'],

            // Nyeri County
            ['name' => 'Kieni', 'county' => 'Nyeri'],
            ['name' => 'Mathira', 'county' => 'Nyeri'],
            ['name' => 'Mukurweini', 'county' => 'Nyeri'],
            ['name' => 'Nyeri Town', 'county' => 'Nyeri'],
            ['name' => 'Othaya', 'county' => 'Nyeri'],
            ['name' => 'Tetu', 'county' => 'Nyeri'],

            // Samburu County
            ['name' => 'Samburu East', 'county' => 'Samburu'],
            ['name' => 'Samburu North', 'county' => 'Samburu'],
            ['name' => 'Samburu West', 'county' => 'Samburu'],

            // Siaya County
            ['name' => 'Alego Usonga', 'county' => 'Siaya'],
            ['name' => 'Bondo', 'county' => 'Siaya'],
            ['name' => 'Gem', 'county' => 'Siaya'],
            ['name' => 'Rarieda', 'county' => 'Siaya'],
            ['name' => 'Ugenya', 'county' => 'Siaya'],
            ['name' => 'Ugunja', 'county' => 'Siaya'],

            // Taita Taveta County
            ['name' => 'Mwatate', 'county' => 'Taita Taveta'],
            ['name' => 'Taveta', 'county' => 'Taita Taveta'],
            ['name' => 'Voi', 'county' => 'Taita Taveta'],
            ['name' => 'Wundanyi', 'county' => 'Taita Taveta'],

            // Tana River County
            ['name' => 'Bura', 'county' => 'Tana River'],
            ['name' => 'Galole', 'county' => 'Tana River'],
            ['name' => 'Garsen', 'county' => 'Tana River'],

            // Tharaka Nithi County
            ['name' => 'Chuka/Igambang\'ombe', 'county' => 'Tharaka Nithi'],
            ['name' => 'Maara', 'county' => 'Tharaka Nithi'],
            ['name' => 'Tharaka', 'county' => 'Tharaka Nithi'],

            // Trans Nzoia County
            ['name' => 'Cherangany', 'county' => 'Trans Nzoia'],
            ['name' => 'Endebess', 'county' => 'Trans Nzoia'],
            ['name' => 'Kwanza', 'county' => 'Trans Nzoia'],
            ['name' => 'Saboti', 'county' => 'Trans Nzoia'],
            ['name' => 'Kiminini', 'county' => 'Trans Nzoia'],

            // Turkana County
            ['name' => 'Loima', 'county' => 'Turkana'],
            ['name' => 'Turkana Central', 'county' => 'Turkana'],
            ['name' => 'Turkana East', 'county' => 'Turkana'],
            ['name' => 'Turkana North', 'county' => 'Turkana'],
            ['name' => 'Turkana South', 'county' => 'Turkana'],
            ['name' => 'Turkana West', 'county' => 'Turkana'],

            // Uasin Gishu County
            ['name' => 'Ainabkoi', 'county' => 'Uasin Gishu'],
            ['name' => 'Kapseret', 'county' => 'Uasin Gishu'],
            ['name' => 'Kesses', 'county' => 'Uasin Gishu'],
            ['name' => 'Moiben', 'county' => 'Uasin Gishu'],
            ['name' => 'Soy', 'county' => 'Uasin Gishu'],
            ['name' => 'Turbo', 'county' => 'Uasin Gishu'],

            // Vihiga County
            ['name' => 'Emuhaya', 'county' => 'Vihiga'],
            ['name' => 'Hamisi', 'county' => 'Vihiga'],
            ['name' => 'Luanda', 'county' => 'Vihiga'],
            ['name' => 'Sabatia', 'county' => 'Vihiga'],
            ['name' => 'Vihiga', 'county' => 'Vihiga'],

            // Wajir County
            ['name' => 'Eldas', 'county' => 'Wajir'],
            ['name' => 'Tarbaj', 'county' => 'Wajir'],
            ['name' => 'Wajir East', 'county' => 'Wajir'],
            ['name' => 'Wajir North', 'county' => 'Wajir'],
            ['name' => 'Wajir South', 'county' => 'Wajir'],
            ['name' => 'Wajir West', 'county' => 'Wajir'],

            // West Pokot County
            ['name' => 'Kapenguria', 'county' => 'West Pokot'],
            ['name' => 'Kacheliba', 'county' => 'West Pokot'],
            ['name' => 'Pokot South', 'county' => 'West Pokot'],
            ['name' => 'Sigor', 'county' => 'West Pokot'],
        ];

        foreach ($constituencies as $constituency) {
            Constituency::create($constituency);
        }
    }
}
