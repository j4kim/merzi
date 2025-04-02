<?php $this->layout('layout'); ?>

<form
    class="flex flex-col gap-2 mt-4"
    method="POST"
    action="login"
>
    <p>
        <input
            class="border border-slate-300 rounded-sm bg-slate-100 w-50 px-4 py-2"
            name="passphrase"
            type="password"
            placeholder="mot de passe"
        >
    </p>
    <p>
        <button
            class="border border-slate-300 rounded-sm bg-slate-100 w-50 px-4 py-2"
            type="submit"
        >
            Connexion
        </button>
    </p>
</form>