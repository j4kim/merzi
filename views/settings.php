<?php $this->layout('layout'); ?>

<form
    class="flex flex-col gap-3 mt-4"
    method="POST"
    action="settings">
    <?php foreach (J4kim\Merzi\Config::calendars() as $cal): ?>
        <div>
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
            <div class="mt-1">
                <label>
                    <input
                        type="checkbox"
                        name="enabled[]"
                        <?= $cal->enabled ? 'checked' : '' ?>>
                    Activé
                </label>
            </div>
        </div>
    <?php endforeach; ?>

    <p class="my-2">
        <button
            class="border border-slate-300 rounded-sm bg-slate-500 text-white hover:bg-slate-600 w-full px-4 py-2"
            type="submit">
            Sauver
        </button>
    </p>

    <div>
        <a href=".." class="hover:opacity-50">Retour</a>
    </div>
</form>