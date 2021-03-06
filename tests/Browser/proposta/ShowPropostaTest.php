<?php

namespace Tests\Browser\proposta;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowPropostaTest extends DuskTestCase
{
    public function test_view_show_proposta_existente()
    {
        $this->browse(function (Browser $browser) { 
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('propostas.show', ['startup' => $proposta->startup, 'proposta' => $proposta])
                    ->assertSee($proposta->titulo)
                    ->assertSee($proposta->descricao)
                    ->assertSee($proposta->startup->nome)
                    ->assertSee($proposta->startup->email)
                    ->assertSee($proposta->startup->area->nome);
            $this->resetar_session();
        });
    }

    public function test_view_show_proposta_inexistente()
    {
        $this->browse(function (Browser $browser) { 
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('propostas.show', ['startup' => $proposta->startup, 'proposta' => $proposta->id + 1])
                    ->assertSee(404);
            $this->resetar_session();
        });
    }
}
