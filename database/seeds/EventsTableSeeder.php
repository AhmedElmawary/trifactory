<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'name' => 'Sahl Hasheesh Endurance Festival - Spring Edition 2019',
            'country' => 'EG',
            'city' => 'Hurghada',
            'address' => 'Sahl Hashish Road',
            'event_start' => '2019-04-03 00:00:00',
            'event_end' => '2019-04-06 00:00:00',
            'published' => 'yes',
            'details' => "GENERAL INFO

            The Sahl Hasheesh Endurance Festival takes place from April 3-6, 2019 for the 8th time!
            ​
            For the sixth year running Egypt's finest Red Sea resort, Sahl Hasheesh, will host triathletes from all across the country and region. Last year's edition was the biggest triathlon/multi-sport event ever to take place in Egypt with over 1000 athletes from 30 different nationalities competing in the overall and age group standings.
             
            Last year, the Sahl Hasheesh Endurance Festival took place from November 21-24. Join us on our iconic race course and take on your choice of the Supersprint, Sprint, and Olympic distances, as well as the Aquathlon and a new swim-bike-run challenge that will challenge the very best athletes out there. Organised to the highest of international endurance sports standards, this is Egypt's biggest and best multi-sport event! 
            ​
            DESTINATION
            Situated around a stunning bay on the Red Sea coast just 15km south of Hurghada International Airport, Sahl Hasheesh is quickly becoming Egypt’s premier holiday destination and a must-go for sports travel. Sahl Hasheesh is also turning into the Middle East’s premier triathlon destination. This April, we’re back with a revamped itinerary, spanning three days and taking you through the calm, transparent waters of the bay, the smooth palm-lined avenues of the resort, and the scenic seaside promenade, to give you the best swim-bike-run racing experience available.
            For more information about Sahl Hasheesh click here.
            
            RACES
            - Tribal Race
            Sprint Distance, Supersprint Distance 
            - Olympic Distance*
            1500M swim, 40KM bike, 10KM run 
            - Sprint Distance* 
            750M swim, 20KM bike, 5KM run    
            - Supersprint Distance
            300M swim, 10KM bike, 2.5KM run                
            - Youth Distance (ages 8-12)    
            100M swim, 4KM bike, 1KM run   
            - 1K Kids Race (ages 5-8)   
            1KM run 
            
            *Relay available in the Sprint and Olympic triathlons only
            
            SCHEDULE
            Wednesday 3 April                                                      
            18:00 – 21:00         Athlete Registration 
            20:00 – 20:30     Race Briefing (Arabic)
            20:30 – 21:00       Race Briefing (English)
             
            Thursday 4 April
                    07:00              Supersprint Male Distance
                    15:00               Supersprint Female Distance                                  
            19:00 – 21:00         Athlete Registration 
            20:00 – 20:30     Race Briefing (Arabic)
            20:30 – 21:00       Race Briefing (English)
            ​
            Friday 23 November                                                  
                    07:00             Sprint Distance
                    10:00             Aquathlon/Biathle Distance
                    12:00             Prayers Break
                    15:00             Youth Race
                    16:00             1K Kids Race         
            19:00 – 21:00       Athlete Registration 
            20:00 – 20:30     Race Briefing (Arabic)
            20:30 – 21:00       Race Briefing (English)
            ​
            Saturday 24 November                                       
                 07:00                    Tribal Distance 
                 12:00                    Beach Closing Ceremony​
            
            **Awards, medals, & prizes will be presented following each race.
            
            RANKING
            All participants are ranked per age group and per gender, with the top finishers in every 5-year age group earning gold, silver, and bronze medals, while the top overall winners are honoured on the podium, receiving their champions' medals and prizes.
            Check out the results of the Sahl Hasheesh Triathlon 2016, and Sahl Hasheesh Triathlon 2017 - Spring Edition.
            
            TRAINING
            Triathlon Training Program
            The best triathlon training led by coaches who are triathletes themselves. 100% Certified. 100% Dedicated. 100% Triathlon. Training is offered at Wadi Degla Club in New Cairo, Palm Hills Club and NewGiza Sports Club in 6th of October, and Zamalek via the Gezira Triathlon Team. During the week swimming and running take place at our training locations. Cycling takes place on the weekends, on Friday starting from Arkan in Sheikh Zayed, and on Saturday starting from the Sokhna Road Gates. 
            Athletes can choose to train for one, two, or all three sports. Click here to join the Triathlon Training Program today!
            ​
            Personalised Training Program via Training Peaks
            Produced by our IRONMAN-certified triathlon coaches, your Personalised Training Program gives you the flexibility to train at your own convenience while at the same time benefiting from regular follow-up from your coach. All you have to do is stick to the plan and the results are guaranteed! 
            Get your Personalised Training Program NOW!
            
            TRAVEL
            Accommodation, transportation, and bike transfer offers are available to all Sahl Hasheesh visitors (participants and spectators) for the triathlon weekend including special discounted rates at different hotels in Sahl Hasheesh, bike transfer, and airport pick-up. Whether you are coming to compete or to cheer and support your friends and family, we have the package for you!
             
            
            
            
            ",
        ]);
    }
}
