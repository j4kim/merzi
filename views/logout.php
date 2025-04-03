<?php $this->layout('layout'); ?>

<form
    class="flex flex-col gap-2 mt-4"
    method="POST"
    action="logout">
    <p>
        <button
            class="border border-slate-300 rounded-sm bg-slate-500 text-white hover:bg-slate-600 w-50 px-4 py-2"
            type="submit">
            Déconnexion
        </button>
    </p>
</form>