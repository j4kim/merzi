<?php $this->layout('layout'); ?>

<div class="my-6">
    <a href=".." class="hover:opacity-50">← Retour</a>
</div>


<script>
    function deleteCal(btn) {
        btn.closest('.calconfig').remove();
    }
</script>

<form
    class="flex flex-col gap-8"
    method="POST"
    action="settings">
    <div
        class="flex flex-col gap-2">
        Calendriers
        <?php foreach (J4kim\Merzi\Config::calendars() as $index => $cal): ?>
            <div class="calconfig">
                <div class="flex gap-2 flex-wrap">
                    <input
                        class="border border-slate-300 rounded-sm bg-slate-100 w-50 px-4 py-2"
                        name="name[]"
                        type="string"
                        placeholder="Nom"
                        required
                        value="<?= $cal->name ?>">
                    <input
                        class="border border-slate-300 rounded-sm bg-slate-100 grow px-4 py-2"
                        name="url[]"
                        type="url"
                        placeholder="URL"
                        required
                        value="<?= $cal->url ?>">
                </div>
                <div class="my-1 flex justify-between">
                    <label>
                        <input
                            type="checkbox"
                            name="enabled[]"
                            value="<?= $index ?>"
                            <?= $cal->enabled ? 'checked' : '' ?>>
                        Activé
                    </label>
                    <button
                        type="button"
                        class="hover:opacity-50 disabled:opacity-50"
                        onclick="deleteCal(this)"
                        <?= $index === 0 ? 'disabled' : ''  ?>>
                        × Supprimer
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <p class="mb-2">Expression régulière pour filtrer les événements libres</p>
        <input
            class="border border-slate-300 rounded-sm bg-slate-100 w-full px-4 py-2"
            name="regex"
            type="regex"
            required
            value="<?= J4kim\Merzi\Config::regex() ?>">
    </div>

    <div>
        <label>
            <input
                type="checkbox"
                name="showIndividual"
                <?= J4kim\Merzi\Config::showIndividual() ? 'checked' : '' ?>>
            Afficher les plage libres de chaque personne
        </label>
    </div>

    <div>
        <label>
            <input
                type="checkbox"
                name="showCommon"
                <?= J4kim\Merzi\Config::showCommon() ? 'checked' : '' ?>>
            Afficher les plages libres pour tout le monde
        </label>
    </div>

    <p>
        <button
            class="border border-slate-300 rounded-sm bg-slate-500 text-white hover:bg-slate-600 w-full px-4 py-2"
            type="submit">
            Sauver
        </button>
    </p>
</form>