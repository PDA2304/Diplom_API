<?php

namespace Database\Seeders;

use App\Models\TypaTable;
use App\Models\TypeAction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $typeActionName = array(
            'Добавление',
            'Данные были перемещены в корзину',
            'Данные были восстановлены',
            'Данные были изменены',
            'Доступ к данным был увеличен',
            'Доступ к данным был уменьшен',
        );

        $typeTable = array(
            'notes',
            'files',
            'account',
            'data',
        );

        foreach ($typeTable as $key) {
            TypaTable::create(
                [
                    'table_name' => $key
                ]
            );
        }

        foreach ($typeActionName as $key) {
            TypeAction::create(
                [
                    'action_name' => $key
                ]
            );
        }

        $employee = new User();

        $employee->create([
            'role' => true,
            'user_name' => 'administrator',
            'login' => 'admin',
            'password' => Hash::make('admin'),
        ]);


        DB::statement('
            CREATE OR REPLACE FUNCTION public.history_account()
            RETURNS trigger
            LANGUAGE plpgsql
            COST 100
            VOLATILE NOT LEAKPROOF
            AS $BODY$
                begin
                    if(TG_OP = \'INSERT\') then
                    INSERT INTO public.actions(
                        action_date, user_id, type_action_id,data_id,type_table_id)
                        VALUES (clock_timestamp(), NEW.user_id, 1,NEW.id,3);
                        return NEW;
                    end if;
                    if(TG_OP = \'UPDATE\') then
                        if(NEW.account_name != OLD.account_name OR NEW.login != OLD.login OR NEW.password != OLD.password OR NEW.description != OLD.description)
                        then 
                            INSERT INTO public.actions(
                            action_date, user_id, type_action_id,data_id,type_table_id)
                            VALUES (clock_timestamp(), OLD.user_id, 4,OLD.id,3);
                        return NEW;
                        end if;
                            
                        if(NEW.logic_delete = false) 
                        then 
                            INSERT INTO public.actions(
                            action_date, user_id, type_action_id,data_id,type_table_id)
                            VALUES (clock_timestamp(), OLD.user_id, 3,OLD.id,3);
                        end if;
                        
                        if(NEW.logic_delete = true) 
                        then 
                            INSERT INTO public.actions(
                            action_date, user_id, type_action_id,data_id,type_table_id)
                            VALUES (clock_timestamp(), OLD.user_id, 2,OLD.id,3);
                        end if;
                        
                        RETURN NULL;
                    end if;
                    
                end;
                $BODY$;
        ');

        DB::statement('  
            CREATE TRIGGER history_account
            AFTER INSERT OR UPDATE 
            ON public.account
            FOR EACH ROW
            EXECUTE FUNCTION public.history_account();
        ');
        
        DB::statement('
            CREATE OR REPLACE FUNCTION public.history_notes()
            RETURNS trigger
            LANGUAGE \'plpgsql\'
            COST 100
            VOLATILE NOT LEAKPROOF
            AS $BODY$
                    begin
                        if(TG_OP = \'INSERT\') then
                        INSERT INTO public.actions(
                            action_date, user_id, type_action_id,data_id,type_table_id)
                            VALUES (clock_timestamp(), NEW.user_id, 1,NEW.id,1);
                            return NEW;
                        end if;
                        if(TG_OP = \'UPDATE\') then
                            if(NEW.notes_name != OLD.notes_name OR NEW.content != OLD.content OR NEW.description != OLD.description)
                            then 
                                INSERT INTO public.actions(
                                action_date, user_id, type_action_id,data_id,type_table_id)
                                VALUES (clock_timestamp(), OLD.user_id, 4,OLD.id,1);
                            return NEW;
                            end if;
                                
                            if(NEW.logic_delete = false) 
                            then 
                                INSERT INTO public.actions(
                                action_date, user_id, type_action_id,data_id,type_table_id)
                                VALUES (clock_timestamp(), OLD.user_id, 3,OLD.id,1);
                            end if;
                            
                            if(NEW.logic_delete = true) 
                            then 
                                INSERT INTO public.actions(
                                action_date, user_id, type_action_id,data_id,type_table_id)
                                VALUES (clock_timestamp(), OLD.user_id, 2,OLD.id,1);
                            end if;
                            
                            RETURN NULL;
                        end if;
                        
                    end;
                    $BODY$;
        ');

        DB::statement('  
            CREATE TRIGGER history_notes
            AFTER INSERT OR UPDATE 
            ON public.notes
            FOR EACH ROW
            EXECUTE FUNCTION public.history_notes();
        ');
    }
}
