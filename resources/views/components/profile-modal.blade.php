<!-- ============================================================
     MODAL DE PERFIL (Solo para usuarios logueados)
     Archivo único: HTML + CSS + JS · Laravel 12 + Bootstrap 5
     Pestañas: Información | Seguridad
     ============================================================ -->
@auth
@php
    $u = auth()->user();
    $infoFields = ['nombre', 'email', 'avatar', 'bio'];
    $secFields  = ['password'];
    $openSecurity = $errors->hasAny($secFields) && !$errors->hasAny($infoFields);
@endphp

{{-- Sprite de iconos: se define una sola vez y se reutiliza con <use> --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="pf-user" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
    <symbol id="pf-mail" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></symbol>
    <symbol id="pf-link" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></symbol>
    <symbol id="pf-edit" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></symbol>
    <symbol id="pf-lock" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
    <symbol id="pf-shield" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></symbol>
    <symbol id="pf-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></symbol>
    <symbol id="pf-eyeoff" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><path d="m1 1 22 22"/></symbol>
    <symbol id="pf-camera" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></symbol>
    <symbol id="pf-x" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></symbol>
    <symbol id="pf-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></symbol>
    <symbol id="pf-check" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-10 10-3-3"/></symbol>
    <symbol id="pf-alert" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></symbol>
    <symbol id="pf-leaf" viewBox="0 0 24 24"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></symbol>
    <symbol id="pf-star" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/></symbol>
</svg>

<style>
    /* ---------- Tokens (paleta del sitio) ---------- */
    #profileModal{
        --g50:#f0fdf4; --g100:#dcfce7; --g500:#22c55e; --g600:#16a34a;
        --or:#f97316; --ink:#111827; --mut:#6b7280; --fld:#f9fafb; --red:#ef4444;
        --ease:cubic-bezier(.22,1,.36,1);
    }
    #profileModal .i{width:1em;height:1em;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex:none}
    .modal-backdrop.show{backdrop-filter:blur(3px)}

    /* Entrada del modal */
    #profileModal.fade .modal-dialog{transform:translateY(22px) scale(.96);transition:transform .4s var(--ease)}
    #profileModal.show .modal-dialog{transform:none}
    #profileModal .modal-content{max-width:520px;margin:0 auto}

    /* ---------- Cabecera ---------- */
    .pf-head{position:relative;overflow:hidden;padding:2rem 1.5rem 1.25rem;text-align:center;
        background:linear-gradient(180deg,var(--g50),#fff)}
    .pf-leaf{position:absolute;color:var(--g500);opacity:.18;font-size:34px;pointer-events:none}
    .pf-leaf.a{top:14px;left:18px;transform:rotate(-20deg)}
    .pf-leaf.b{bottom:10px;right:22px;font-size:26px;color:var(--or);transform:rotate(25deg)}
    .pf-x{position:absolute;top:12px;right:12px;z-index:2;width:34px;height:34px;border:0;border-radius:50%;
        background:rgba(255,255,255,.85);color:var(--mut);display:grid;place-items:center;font-size:15px;cursor:pointer;
        box-shadow:0 2px 8px rgba(0,0,0,.07);transition:transform .3s var(--ease),color .2s}
    .pf-x:hover{transform:rotate(90deg);color:var(--ink)}

    .pf-av{position:relative;width:96px;height:96px;margin:0 auto .9rem}
    .pf-av::before{content:"";position:absolute;inset:-5px;border-radius:50%;
        background:conic-gradient(var(--g500),#86efac,var(--g500));opacity:0;transform:scale(.85)}
    #profileModal.pf-in .pf-av::before{animation:pf-ring .7s var(--ease) .1s forwards}
    @keyframes pf-ring{to{opacity:1;transform:none}}
    .pf-pic{position:relative;width:100%;height:100%;border-radius:50%;border:4px solid #fff;overflow:hidden;
        background:linear-gradient(135deg,var(--g500),var(--g600));box-shadow:0 10px 24px rgba(22,163,74,.22)}
    .pf-pic img{width:100%;height:100%;object-fit:cover;display:block}
    .pf-pic b{position:absolute;inset:0;display:none;place-items:center;color:#fff;font-size:2rem;font-weight:700}
    .pf-pic.no-img img{display:none}
    .pf-pic.no-img b{display:grid}
    .pf-pic.swap img{animation:pf-swap .4s var(--ease)}
    @keyframes pf-swap{from{transform:scale(1.15);opacity:.3}}
    .pf-cam{position:absolute;right:-2px;bottom:2px;width:30px;height:30px;border-radius:50%;border:3px solid #fff;
        background:var(--g500);color:#fff;display:grid;place-items:center;font-size:13px;padding:0;cursor:pointer;
        box-shadow:0 4px 10px rgba(34,197,94,.4);transition:transform .25s var(--ease),background .2s}
    .pf-cam:hover{transform:scale(1.15);background:var(--g600)}

    .pf-title{font-size:1.35rem;font-weight:800;color:var(--g600);margin:0}
    .pf-sub{font-size:.82rem;color:var(--mut);margin:.1rem 0 .8rem}
    .pf-pill{display:inline-flex;align-items:center;gap:.35rem;font-size:.72rem;font-weight:600;color:var(--g600);
        background:#fff;border:1px solid var(--g100);border-radius:999px;padding:.28rem .75rem}
    .pf-pill .i{color:var(--or)}
    .pf-bar{width:170px;height:4px;margin:.55rem auto 0;border-radius:4px;background:#e5e7eb;overflow:hidden}
    .pf-bar i{display:block;height:100%;width:0;border-radius:4px;background:linear-gradient(90deg,var(--g500),var(--g600));
        transition:width .6s var(--ease)}

    /* ---------- Pestañas ---------- */
    .pf-body{padding:1.1rem 1.5rem 1.4rem}
    .pf-tabs{position:relative;display:grid;grid-template-columns:1fr 1fr;padding:4px;border-radius:14px;background:#f3f4f6}
    .pf-tabs::before{content:"";position:absolute;top:4px;bottom:4px;left:4px;width:calc(50% - 4px);border-radius:11px;
        background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.08);transition:transform .35s var(--ease)}
    .pf-tabs[data-tab="1"]::before{transform:translateX(100%)}
    .pf-tab{position:relative;z-index:1;border:0;background:none;padding:.65rem;font-size:.85rem;font-weight:600;color:var(--mut);
        display:flex;align-items:center;justify-content:center;gap:.4rem;cursor:pointer;transition:color .25s}
    .pf-tab[aria-selected="true"]{color:var(--g600)}
    .pf-tab .dot{width:7px;height:7px;border-radius:50%;background:var(--red);display:none}
    .pf-tab.err .dot{display:inline-block}

    .pf-pane{margin-top:1.1rem}
    .pf-pane[hidden]{display:none}
    .pf-pane.show{animation:pf-pane .35s var(--ease)}
    @keyframes pf-pane{from{opacity:0;transform:translateY(10px)}}

    /* ---------- Campos ---------- */
    .pf-lbl{display:flex;align-items:center;gap:.4rem;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:.4rem}
    .pf-lbl .i{color:var(--g500);font-size:14px}
    .pf-lbl em{font-style:normal;font-weight:500;font-size:.68rem;color:#9ca3af;background:#f3f4f6;border-radius:6px;padding:.05rem .45rem}
    .pf-f{position:relative}
    .pf-f>.i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:16px;pointer-events:none;transition:color .2s}
    .pf-f.area>.i{top:19px;transform:none}
    .pf-in-t{width:100%;border:2px solid transparent;border-radius:12px;background:var(--fld);color:var(--ink);outline:0;
        padding:.7rem 1rem .7rem 2.55rem;font-size:.93rem;transition:border-color .2s,background .2s,box-shadow .25s}
    .pf-in-t:hover{background:#f3f4f6}
    .pf-in-t:focus{background:#fff;border-color:var(--g500);box-shadow:0 0 0 4px rgba(34,197,94,.14)}
    .pf-f:focus-within>.i{color:var(--g500)}
    .pf-in-t.bad{border-color:var(--red);background:#fff}
    textarea.pf-in-t{resize:none;padding-top:.75rem}
    .pf-in-t.tg{padding-right:2.9rem}
    .pf-eye{position:absolute;right:7px;top:50%;transform:translateY(-50%);width:34px;height:34px;border:0;border-radius:10px;
        background:none;color:#9ca3af;display:grid;place-items:center;font-size:16px;cursor:pointer;transition:background .2s,color .2s}
    .pf-eye:hover{background:var(--g50);color:var(--g600)}
    .pf-note{display:flex;justify-content:space-between;gap:.5rem;font-size:.7rem;color:#9ca3af;margin-top:.3rem}
    .pf-note.bad,.pf-err{color:var(--red)}
    .pf-err{font-size:.72rem;margin-top:.3rem}
    #pfCount.warn{color:var(--or);font-weight:600}

    /* Seguridad */
    .pf-tip{display:flex;gap:.7rem;align-items:flex-start;padding:.8rem 1rem;border-radius:12px;background:var(--g50);
        border:1px solid var(--g100);color:#166534;font-size:.8rem;line-height:1.4;margin-bottom:1rem}
    .pf-tip .i{font-size:18px;color:var(--g600);margin-top:1px}
    .pf-meter{display:grid;grid-template-columns:repeat(4,1fr);gap:4px;margin-top:.55rem}
    .pf-meter i{height:4px;border-radius:4px;background:#e5e7eb;transition:background .3s}
    .pf-meter[data-l="1"] i.on{background:var(--red)}
    .pf-meter[data-l="2"] i.on{background:var(--or)}
    .pf-meter[data-l="3"] i.on{background:#84cc16}
    .pf-meter[data-l="4"] i.on{background:var(--g500)}
    .pf-sm{font-size:.72rem;color:var(--mut);margin-top:.3rem;min-height:1em}
    .pf-sm.ok{color:var(--g600)} .pf-sm.no{color:var(--red)}

    /* ---------- Alertas y botones ---------- */
    .pf-al{display:flex;align-items:center;gap:.6rem;padding:.7rem 1rem;margin-bottom:1rem;border-radius:12px;font-size:.82rem;font-weight:600}
    .pf-al.ok{background:var(--g50);color:var(--g600);border:1px solid var(--g100)}
    .pf-al.no{background:#fef2f2;color:#b91c1c;border:1px solid #fee2e2}
    .pf-al .i{font-size:17px}
    .pf-save{width:100%;margin-top:1.4rem;border:0;border-radius:12px;padding:.85rem;color:#fff;font-weight:700;font-size:.95rem;
        display:flex;align-items:center;justify-content:center;gap:.5rem;cursor:pointer;
        background:linear-gradient(135deg,var(--g500),var(--g600));box-shadow:0 6px 18px rgba(34,197,94,.35);
        transition:transform .2s var(--ease),box-shadow .25s,opacity .2s}
    .pf-save:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 10px 24px rgba(34,197,94,.42)}
    .pf-save:active:not(:disabled){transform:scale(.98)}
    .pf-save:disabled{opacity:.5;cursor:not-allowed;box-shadow:none}
    .pf-save.dirty{animation:pf-pulse 1.8s ease-out infinite}
    @keyframes pf-pulse{0%{box-shadow:0 6px 18px rgba(34,197,94,.35),0 0 0 0 rgba(34,197,94,.4)}
        70%,100%{box-shadow:0 6px 18px rgba(34,197,94,.35),0 0 0 12px rgba(34,197,94,0)}}
    .pf-save .sp{display:none;width:17px;height:17px;border:2.5px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:pf-rot .7s linear infinite}
    .pf-save.load .sp{display:inline-block} .pf-save.load .i{display:none}
    @keyframes pf-rot{to{transform:rotate(360deg)}}
    .pf-cancel{display:block;width:100%;margin-top:.5rem;border:0;background:none;padding:.5rem;font-size:.85rem;color:var(--mut);cursor:pointer;transition:color .2s}
    .pf-cancel:hover{color:var(--ink)}
    .pf-shake{animation:pf-sh .4s}
    @keyframes pf-sh{25%,75%{transform:translateX(-5px)}50%{transform:translateX(5px)}}

    @media (prefers-reduced-motion:reduce){
        #profileModal *,#profileModal *::before{animation:none!important;transition:none!important}
    }
</style>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="pfTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="pf-head">
                <svg class="i pf-leaf a"><use href="#pf-leaf"/></svg>
                <svg class="i pf-leaf b"><use href="#pf-leaf"/></svg>
                <button type="button" class="pf-x" data-bs-dismiss="modal" aria-label="Cerrar"><svg class="i"><use href="#pf-x"/></svg></button>

                <div class="pf-av">
                    <div class="pf-pic {{ $u->avatar ? '' : 'no-img' }}" id="pfPic">
                        @if($u->avatar)<img id="pfImg" src="{{ $u->avatar }}" alt="Foto de perfil">@else<img id="pfImg" alt="Foto de perfil">@endif
                        <b id="pfLetter">{{ strtoupper(mb_substr($u->nombre, 0, 1)) }}</b>
                    </div>
                    <button type="button" class="pf-cam" id="pfCam" aria-label="Cambiar foto" title="Cambiar foto"><svg class="i"><use href="#pf-camera"/></svg></button>
                </div>

                <h4 class="pf-title" id="pfTitle">Mi perfil</h4>
                <p class="pf-sub">Actualiza tu información personal</p>
                <span class="pf-pill"><svg class="i"><use href="#pf-star"/></svg><span id="pfPct">Perfil 0% completo</span></span>
                <div class="pf-bar"><i id="pfBarFill"></i></div>
            </div>

            <!-- Body -->
            <div class="pf-body">

                @if(session('success'))
                    <div class="pf-al ok" role="status"><svg class="i"><use href="#pf-check"/></svg>{{ session('success') }}</div>
                @endif
                @if($errors->hasAny(array_merge($infoFields, $secFields)))
                    <div class="pf-al no" role="alert"><svg class="i"><use href="#pf-alert"/></svg>Revisa los campos marcados para continuar.</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" id="pfForm" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Pestañas -->
                    <div class="pf-tabs" id="pfTabs" data-tab="{{ $openSecurity ? 1 : 0 }}" role="tablist">
                        <button type="button" class="pf-tab {{ $errors->hasAny($infoFields) ? 'err' : '' }}" role="tab" data-i="0" aria-selected="{{ $openSecurity ? 'false' : 'true' }}">
                            <svg class="i"><use href="#pf-user"/></svg>Información<span class="dot"></span>
                        </button>
                        <button type="button" class="pf-tab {{ $errors->hasAny($secFields) ? 'err' : '' }}" role="tab" data-i="1" aria-selected="{{ $openSecurity ? 'true' : 'false' }}">
                            <svg class="i"><use href="#pf-lock"/></svg>Seguridad<span class="dot"></span>
                        </button>
                    </div>

                    <!-- Panel 1: Información -->
                    <div class="pf-pane" role="tabpanel" data-p="0" {{ $openSecurity ? 'hidden' : '' }}>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="pf-lbl" for="pfNombre"><svg class="i"><use href="#pf-user"/></svg>Nombre completo</label>
                                <div class="pf-f"><svg class="i"><use href="#pf-user"/></svg>
                                    <input type="text" id="pfNombre" name="nombre" required autocomplete="name" value="{{ old('nombre', $u->nombre) }}" class="pf-in-t @error('nombre') bad @enderror">
                                </div>
                                @error('nombre')<div class="pf-err">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="pf-lbl" for="pfEmail"><svg class="i"><use href="#pf-mail"/></svg>Correo electrónico</label>
                                <div class="pf-f"><svg class="i"><use href="#pf-mail"/></svg>
                                    <input type="email" id="pfEmail" name="email" required autocomplete="email" value="{{ old('email', $u->email) }}" class="pf-in-t @error('email') bad @enderror">
                                </div>
                                @error('email')<div class="pf-err">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="pf-lbl" for="pfAvatar"><svg class="i"><use href="#pf-link"/></svg>URL de tu foto de perfil <em>Opcional</em></label>
                                <div class="pf-f"><svg class="i"><use href="#pf-link"/></svg>
                                    <input type="url" id="pfAvatar" name="avatar" placeholder="https://ejemplo.com/mi-foto.jpg" value="{{ old('avatar', $u->avatar) }}" class="pf-in-t @error('avatar') bad @enderror">
                                </div>
                                @error('avatar')<div class="pf-err">{{ $message }}</div>@else<div class="pf-note" id="pfAvNote">Pega el enlace de una imagen (JPG, PNG).</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="pf-lbl" for="pfBio"><svg class="i"><use href="#pf-edit"/></svg>Biografía <em>Opcional</em></label>
                                <div class="pf-f area"><svg class="i"><use href="#pf-edit"/></svg>
                                    <textarea id="pfBio" name="bio" rows="3" maxlength="200" placeholder="Cuéntale a la comunidad sobre ti y tus metas nutricionales..." class="pf-in-t @error('bio') bad @enderror">{{ old('bio', $u->bio) }}</textarea>
                                </div>
                                @error('bio')<div class="pf-err">{{ $message }}</div>@else<div class="pf-note"><span>Comparte tus metas saludables</span><span id="pfCount">0/200</span></div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel 2: Seguridad -->
                    <div class="pf-pane" role="tabpanel" data-p="1" {{ $openSecurity ? '' : 'hidden' }}>
                        <div class="pf-tip"><svg class="i"><use href="#pf-shield"/></svg>
                            <span>Si no quieres cambiar tu contraseña, deja estos campos en blanco.</span></div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="pf-lbl" for="pfPass"><svg class="i"><use href="#pf-lock"/></svg>Nueva contraseña</label>
                                <div class="pf-f"><svg class="i"><use href="#pf-lock"/></svg>
                                    <input type="password" id="pfPass" name="password" placeholder="Mín. 6 caracteres" autocomplete="new-password" class="pf-in-t tg @error('password') bad @enderror">
                                    <button type="button" class="pf-eye" data-t="pfPass" aria-label="Mostrar u ocultar contraseña"><svg class="i"><use href="#pf-eye"/></svg></button>
                                </div>
                                @error('password')<div class="pf-err">{{ $message }}</div>@enderror
                                <div class="pf-meter" id="pfMeter" data-l="0"><i></i><i></i><i></i><i></i></div>
                                <div class="pf-sm" id="pfMeterTxt"></div>
                            </div>
                            <div class="col-12">
                                <label class="pf-lbl" for="pfPass2"><svg class="i"><use href="#pf-shield"/></svg>Confirmar contraseña</label>
                                <div class="pf-f"><svg class="i"><use href="#pf-shield"/></svg>
                                    <input type="password" id="pfPass2" name="password_confirmation" placeholder="Repite la contraseña" autocomplete="new-password" class="pf-in-t tg">
                                    <button type="button" class="pf-eye" data-t="pfPass2" aria-label="Mostrar u ocultar confirmación"><svg class="i"><use href="#pf-eye"/></svg></button>
                                </div>
                                <div class="pf-sm" id="pfMatch"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="pf-save" id="pfSave" disabled>
                        <svg class="i"><use href="#pf-save"/></svg><span class="sp"></span><span id="pfSaveTxt">Sin cambios</span>
                    </button>
                    <button type="button" class="pf-cancel" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('profileModal');
    if (!modal) return;
    const $ = id => document.getElementById(id);
    const form = $('pfForm'), save = $('pfSave'), saveTxt = $('pfSaveTxt');
    const nombre = $('pfNombre'), email = $('pfEmail'), avatar = $('pfAvatar'), bio = $('pfBio'), pass = $('pfPass'), pass2 = $('pfPass2');
    const fields = [nombre, email, avatar, bio, pass, pass2];

    /* ---------- Animación de entrada (solo ring del avatar) ---------- */
    modal.addEventListener('shown.bs.modal', () => { void modal.offsetWidth; modal.classList.add('pf-in'); });
    modal.addEventListener('hidden.bs.modal', () => {
        modal.classList.remove('pf-in');
        if (!save.classList.contains('load')) {           // descarta cambios sin guardar
            form.reset(); sync(); goTab(0, false);
            avatar.value.trim() ? setPic(avatar.value.trim()) : $('pfPic').classList.add('no-img');
        }
    });

    /* ---------- Pestañas ---------- */
    const tabs = $('pfTabs'), btns = tabs.querySelectorAll('.pf-tab'), panes = form.querySelectorAll('.pf-pane');
    function goTab(i, animate = true) {
        tabs.dataset.tab = i;
        btns.forEach((b, n) => b.setAttribute('aria-selected', n === i));
        panes.forEach((p, n) => {
            p.hidden = n !== i;
            p.classList.remove('show');
            if (n === i && animate) { void p.offsetWidth; p.classList.add('show'); }
        });
    }
    btns.forEach(b => b.addEventListener('click', () => goTab(+b.dataset.i)));

    /* ---------- Avatar: vista previa en vivo ---------- */
    const pic = $('pfPic'), img = $('pfImg'), note = $('pfAvNote');
    const noteTxt = note ? note.textContent : '';
    let t;
    function setPic(url) {
        const p = new Image();
        p.onload = () => { img.src = url; pic.classList.remove('no-img', 'swap'); void pic.offsetWidth; pic.classList.add('swap');
            if (note) { note.textContent = noteTxt; note.classList.remove('bad'); } };
        p.onerror = () => { pic.classList.add('no-img');
            if (note) { note.textContent = 'No pudimos cargar esa imagen. Revisa que el enlace sea público.'; note.classList.add('bad'); } };
        p.src = url;
    }
    img.addEventListener('error', () => pic.classList.add('no-img'));
    avatar.addEventListener('input', () => {
        clearTimeout(t);
        t = setTimeout(() => avatar.value.trim() ? setPic(avatar.value.trim()) : pic.classList.add('no-img'), 400);
    });
    $('pfCam').addEventListener('click', () => { goTab(0); avatar.focus(); avatar.select(); });

    /* ---------- Progreso del perfil ---------- */
    function progress() {
        const done = [nombre, email, avatar, bio].filter(el => el.value.trim()).length * 25;
        $('pfBarFill').style.width = done + '%';
        $('pfPct').textContent = 'Perfil ' + done + '% completo';
    }

    /* ---------- Contador bio ---------- */
    const count = $('pfCount');
    function bioCount() {
        if (!count) return;
        count.textContent = bio.value.length + '/' + bio.maxLength;
        count.classList.toggle('warn', bio.value.length > bio.maxLength * .9);
    }

    /* ---------- Contraseña: ojo, medidor y coincidencia ---------- */
    document.querySelectorAll('.pf-eye').forEach(b => b.addEventListener('click', () => {
        const el = $(b.dataset.t), show = el.type === 'password';
        el.type = show ? 'text' : 'password';
        b.firstElementChild.firstElementChild.setAttribute('href', show ? '#pf-eyeoff' : '#pf-eye');
    }));
    const meter = $('pfMeter'), mTxt = $('pfMeterTxt'), match = $('pfMatch');
    const names = ['', 'Débil', 'Aceptable', 'Buena', 'Excelente'];
    function pwd() {
        const v = pass.value;
        let s = v ? (v.length >= 6) + (v.length >= 10) + (/[A-Z]/.test(v) && /[a-z]/.test(v)) + (/\d/.test(v) && /\W|_/.test(v)) : 0;
        s = v ? Math.max(1, s) : 0;
        meter.dataset.l = s;
        meter.querySelectorAll('i').forEach((b, n) => b.classList.toggle('on', n < s));
        mTxt.textContent = s ? 'Seguridad: ' + names[s] : '';
        if (!pass2.value) { match.textContent = ''; match.className = 'pf-sm'; return; }
        const ok = pass.value === pass2.value;
        match.textContent = ok ? '✓ Las contraseñas coinciden' : 'Las contraseñas no coinciden';
        match.className = 'pf-sm ' + (ok ? 'ok' : 'no');
    }

    /* ---------- Cambios detectados ---------- */
    const dirty = () => fields.some(el => el.value !== el.defaultValue);
    function refresh() {
        const d = dirty();
        save.disabled = !d; save.classList.toggle('dirty', d);
        saveTxt.textContent = d ? 'Guardar cambios' : 'Sin cambios';
    }
    function sync() { $('pfLetter').textContent = (nombre.value.trim()[0] || '?').toUpperCase(); progress(); bioCount(); pwd(); refresh(); }
    fields.forEach(el => el.addEventListener('input', () => { el.classList.remove('bad'); sync(); }));
    sync();

    /* ---------- Envío: validación ligera + estado de carga ---------- */
    form.addEventListener('submit', e => {
        const bad = [];
        if (!nombre.value.trim()) bad.push([nombre, 0]);
        if (!email.value.trim() || !email.validity.valid) bad.push([email, 0]);
        if (pass.value && pass.value.length < 6) bad.push([pass, 1]);
        if (pass.value !== pass2.value) bad.push([pass2, 1]);
        if (bad.length) {
            e.preventDefault();
            goTab(bad[0][1], false);
            bad.forEach(([el]) => { el.classList.add('bad', 'pf-shake'); setTimeout(() => el.classList.remove('pf-shake'), 450); });
            bad[0][0].focus();
            return;
        }
        save.classList.add('load'); save.classList.remove('dirty'); save.disabled = true; saveTxt.textContent = 'Guardando...';
    });

    /* ---------- Reabrir si Laravel devolvió errores o mensaje de éxito ---------- */
    @if($errors->hasAny(array_merge($infoFields, $secFields)) || session('success'))
        window.bootstrap && bootstrap.Modal.getOrCreateInstance(modal).show();
    @endif
});
</script>
@endauth
