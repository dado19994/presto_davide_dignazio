<x-layout>
    <x-page-header
        eyebrow="Nuova pubblicazione"
        title="Pubblica un articolo"
        subtitle="Compila i dettagli e guarda l'anteprima aggiornarsi mentre scrivi"
    />

    <section class="container section-shell">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-xl-11">
                <livewire:create-article-form />
            </div>
        </div>
    </section>
</x-layout>
