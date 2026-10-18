<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'light' ? false : true }"
      :class="{ 'dark': darkMode }"
      class="dark bg-gray-900">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" <head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{{ asset('storage/app/public/' . $settings->favicon) }}" rel="icon" type="image/x-icon" />
    <!-- Inter Font -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Enable dark mode class strategy -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        'glass': 'rgba(255, 255, 255, 0.05)',
                    },
                    backdropBlur: {
                        'xs': '2px',
                    },
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'gradient-y': 'gradient-y 15s ease infinite',
                        'gradient-xy': 'gradient-xy 15s ease infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        'gradient-y': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'center top'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'center center'
                            }
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'gradient-xy': {
                            '0%, 100%': {
                                'background-size': '400% 400%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        },
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Set dark mode as default if no preference is stored
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    // Default to dark if no preference is set
                    this.darkMode = localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme');
                    this.updateTheme();
                },
                darkMode: true, // Set default to true
                toggle() {
                    this.darkMode = !this.darkMode;
                    this.updateTheme();
                },
                updateTheme() {
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            });
        });
    </script>
<script src="https://unpkg.com/lucide@latest"></script>
<!-- Tailwind CDN -->
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

<style>
/* AGROTRADE_CUSTOMER_SHELL_R4: dashboard-only compact translation control */
/* AGROTRADE_LANGUAGE_R5 */
.agrotrade-dashboard-language{width:94px}
.agrotrade-dashboard-language select{font-size:12px;letter-spacing:.02em}
#agrotrade-translation-loader[hidden]{display:none!important}
#agrotrade-translation-loader{display:flex;align-items:center;justify-content:center;width:24px;height:32px;flex:none}
.agrotrade-translation-spinner{width:16px;height:16px;border:2px solid #94a3b8;border-top-color:#2563eb;border-radius:50%;animation:agrotrade-language-spin .65s linear infinite}
@keyframes agrotrade-language-spin{to{transform:rotate(360deg)}}
@media(prefers-reduced-motion:reduce){.agrotrade-translation-spinner{animation-duration:1.8s}}
.agrotrade-dashboard-language{width:70px;flex:none}
.agrotrade-dashboard-language select{display:block;width:100%;height:34px;padding:0 4px;border:1px solid #cbd5e1;border-radius:8px;background:#f8fafc;color:#0f172a;font-size:12px;font-weight:600;color-scheme:light}
.agrotrade-dashboard-language select option{background:#fff;color:#0f172a}
.dark .agrotrade-dashboard-language select{border-color:#475569;background:#1e293b;color:#f8fafc;color-scheme:dark}
.dark .agrotrade-dashboard-language select option{background:#1e293b;color:#f8fafc}
</style>
<script>
window.gtranslateSettings = {default_language:'en', wrapper_selector:'.gtranslate_wrapper_dashboard', flag_style:'3d', alt_flags:{en:'usa'}};
</script>
<script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
 const host=document.querySelector('.agrotrade-dashboard-language'); if(!host)return;
 /* AGROTRADE_LANGUAGE_R5: readable three-letter codes and flags. */
 const languageLabels={en:['ENG','🇺🇸'],fr:['FRA','🇫🇷'],es:['ESP','🇪🇸'],de:['DEU','🇩🇪'],it:['ITA','🇮🇹'],pt:['POR','🇵🇹'],ru:['RUS','🇷🇺'],ar:['ARA','🇸🇦'],zh:['ZHO','🇨🇳'],ja:['JPN','🇯🇵'],ko:['KOR','🇰🇷'],hi:['HIN','🇮🇳'],tr:['TUR','🇹🇷'],nl:['NLD','🇳🇱'],pl:['POL','🇵🇱'],sw:['SWA','🇰🇪'],yo:['YOR','🇳🇬'],ig:['IBO','🇳🇬'],ha:['HAU','🇳🇬'],id:['IND','🇮🇩'],vi:['VIE','🇻🇳'],th:['THA','🇹🇭'],uk:['UKR','🇺🇦']};
 function compact(){host.querySelectorAll('select option').forEach(function(option){
  if(!option.dataset.fullName)option.dataset.fullName=option.textContent.trim();
  const code=String(option.value||'').trim().split('|').pop().toLowerCase();
  if(!/^[a-z]{2,3}(-[a-z]{2,4})?$/.test(code))return;
  const base=code.split('-')[0];
  const match=languageLabels[base];
  const label=match ? match[1]+' '+match[0] : code.toUpperCase();
  if(option.textContent!==label)option.textContent=label;
 });}
 compact();new MutationObserver(compact).observe(host,{childList:true,subtree:true});
 const loader=document.getElementById('agrotrade-translation-loader');
 let loaderTimer=null;
 function hideLoader(){if(loader){loader.hidden=true;loader.setAttribute('aria-hidden','true');}if(loaderTimer){clearTimeout(loaderTimer);loaderTimer=null;}}
 function showLoader(){if(!loader)return;loader.hidden=false;loader.setAttribute('aria-hidden','false');if(loaderTimer)clearTimeout(loaderTimer);loaderTimer=setTimeout(hideLoader,9000);}
 host.addEventListener('change',function(event){if(event.target && event.target.matches('select'))showLoader();},true);
 // GTranslate may change the document without a full navigation. Never leave the indicator stuck.
 window.addEventListener('pageshow',hideLoader);
 window.addEventListener('load',hideLoader);
 document.addEventListener('visibilitychange',function(){if(!document.hidden)hideLoader();});
});
</script>

<!-- AGROTRADE_LANGUAGE_ALIGNMENT_R7: independently aligned flag, code, and chevron -->
<style>
.agrotrade-dashboard-language{width:112px!important;min-width:112px!important}
.agrotrade-dashboard-language .agrotrade-flag-button{display:grid!important;grid-template-columns:24px minmax(0,1fr) 12px!important;align-items:center!important;column-gap:9px!important;width:100%!important;min-height:38px!important;padding:0 10px!important;text-align:left!important;white-space:nowrap!important}
.agrotrade-dashboard-language .agrotrade-flag-image{display:block!important;width:24px!important;height:18px!important;object-fit:cover!important}
.agrotrade-dashboard-language .agrotrade-flag-code{display:block;min-width:0;font-size:12px;font-weight:700;line-height:1;letter-spacing:.035em;text-align:left}
.agrotrade-dashboard-language .agrotrade-flag-chevron{display:block;width:7px;height:7px;border-right:1.6px solid currentColor;border-bottom:1.6px solid currentColor;transform:translateY(-2px) rotate(45deg);opacity:.8;justify-self:center}
.agrotrade-dashboard-language .agrotrade-flag-button[aria-expanded="true"] .agrotrade-flag-chevron{transform:translateY(2px) rotate(225deg)}
.agrotrade-dashboard-language .agrotrade-flag-button:focus-visible{outline:2px solid #3b82f6;outline-offset:2px}
</style>
<!-- AGROTRADE_LANGUAGE_FLAGS_R6: real flag images; original GTranslate select remains authoritative. -->
<style>
.agrotrade-dashboard-language{position:relative;width:92px!important;flex:none}
.agrotrade-dashboard-language .gtranslate_wrapper_dashboard{position:absolute!important;width:1px!important;height:1px!important;overflow:hidden!important;clip-path:inset(50%)!important;white-space:nowrap!important}
.agrotrade-flag-button{display:flex;align-items:center;justify-content:space-between;gap:5px;width:100%;height:34px;padding:0 7px;border:1px solid #cbd5e1;border-radius:8px;background:#f8fafc;color:#0f172a;font-size:12px;font-weight:700}
.dark .agrotrade-flag-button{background:#1e293b;border-color:#475569;color:#f8fafc}
.agrotrade-flag-image{width:21px;height:15px;object-fit:cover;border-radius:2px;box-shadow:0 0 0 1px #0002;flex:none}
.agrotrade-flag-menu{position:absolute;right:0;top:calc(100% + 6px);z-index:100;width:192px;max-height:min(360px,65vh);overflow:auto;border:1px solid #cbd5e1;border-radius:10px;background:#fff;box-shadow:0 12px 30px #0002;padding:5px}
.dark .agrotrade-flag-menu{background:#1e293b;border-color:#475569}
.agrotrade-flag-item{display:flex;align-items:center;gap:10px;width:100%;padding:8px 9px;border-radius:7px;text-align:left;color:#0f172a;font-size:12px}
.dark .agrotrade-flag-item{color:#f8fafc}
.agrotrade-flag-item:hover,.agrotrade-flag-item:focus-visible{background:#e2e8f0;outline:none}
.dark .agrotrade-flag-item:hover,.dark .agrotrade-flag-item:focus-visible{background:#334155}
.agrotrade-flag-item[aria-selected=true]{font-weight:700;background:#eff6ff}
.dark .agrotrade-flag-item[aria-selected=true]{background:#1e3a5f}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
 const host=document.querySelector('.agrotrade-dashboard-language');if(!host)return;
 const country={en:'gb',fr:'fr',es:'es',de:'de',it:'it',pt:'pt',ru:'ru',ar:'sa',zh:'cn',ja:'jp',ko:'kr',hi:'in',tr:'tr',nl:'nl',pl:'pl',sw:'ke',yo:'ng',ig:'ng',ha:'ng',id:'id',vi:'vn',th:'th',uk:'ua'};
 const names={en:'English',fr:'French',es:'Spanish',de:'German',it:'Italian',pt:'Portuguese',ru:'Russian',ar:'Arabic',zh:'Chinese',ja:'Japanese',ko:'Korean',hi:'Hindi',tr:'Turkish',nl:'Dutch',pl:'Polish',sw:'Swahili',yo:'Yoruba',ig:'Igbo',ha:'Hausa',id:'Indonesian',vi:'Vietnamese',th:'Thai',uk:'Ukrainian'};
 const codes={en:'ENG',fr:'FRA',es:'ESP',de:'DEU',it:'ITA',pt:'POR',ru:'RUS',ar:'ARA',zh:'ZHO',ja:'JPN',ko:'KOR',hi:'HIN',tr:'TUR',nl:'NLD',pl:'POL',sw:'SWA',yo:'YOR',ig:'IBO',ha:'HAU',id:'IND',vi:'VIE',th:'THA',uk:'UKR'};
 const button=document.createElement('button');button.type='button';button.className='agrotrade-flag-button';button.setAttribute('aria-label','Choose language');button.setAttribute('aria-haspopup','listbox');button.setAttribute('aria-expanded','false');
 const menu=document.createElement('div');menu.className='agrotrade-flag-menu';menu.setAttribute('role','listbox');menu.hidden=true;
 host.append(button,menu);
 function key(value){return String(value||'').trim().split('|').pop().toLowerCase().split('-')[0];}
 function flag(lang){const img=document.createElement('img');img.className='agrotrade-flag-image';img.src='https://flagcdn.com/24x18/'+(country[lang]||'un')+'.png';img.alt='';img.loading='lazy';return img;}
 function close(){menu.hidden=true;button.setAttribute('aria-expanded','false');}
 function render(){const select=host.querySelector('select');if(!select){button.textContent='Language';return;}
  const options=Array.from(select.options).filter(o=>o.value && !o.disabled);const selected=key(select.value||'en');
  const code=document.createElement('span');code.className='agrotrade-flag-code';code.textContent=codes[selected]||selected.toUpperCase();
  const chevron=document.createElement('span');chevron.className='agrotrade-flag-chevron';chevron.setAttribute('aria-hidden','true');
  button.replaceChildren(flag(selected),code,chevron);
  menu.replaceChildren();options.forEach(function(option){const lang=key(option.value);if(!country[lang])return;
   const item=document.createElement('button');item.type='button';item.className='agrotrade-flag-item';item.setAttribute('role','option');item.setAttribute('aria-selected',String(option.selected));
   item.append(flag(lang),document.createTextNode((codes[lang]||lang.toUpperCase())+' · '+(names[lang]||option.dataset.fullName||lang)));
   item.addEventListener('click',function(){if(select.value!==option.value){select.value=option.value;select.dispatchEvent(new Event('change',{bubbles:true}));}close();render();});menu.appendChild(item);
  });
 }
 button.addEventListener('click',function(){render();menu.hidden=!menu.hidden;button.setAttribute('aria-expanded',String(!menu.hidden));});
 document.addEventListener('click',function(e){if(!host.contains(e.target))close();});
 document.addEventListener('keydown',function(e){if(e.key==='Escape')close();});
 host.addEventListener('change',function(e){if(e.target.matches('select'))render();});
 let lastSignature='';let attempts=0;
 const watcher=setInterval(function(){const s=host.querySelector('select');const signature=s?Array.from(s.options).map(o=>o.value).join(',')+'|'+s.value:'';
 if(signature!==lastSignature){lastSignature=signature;render();}if(++attempts>=60)clearInterval(watcher);},500);
 render();
});
</script>
</head>
<body x-data="{ darkMode: localStorage.theme === 'dark' || !localStorage.theme, sidebarOpen: false }"
      :class="{ 'dark': darkMode }"
      class="dark text-gray-100 bg-gray-900" x-cloak>
      <style>
       body {
    overflow-x: hidden;
  }

  [x-cloak] {
    display: none !important;
  }
        </style>
<!-- AGROTRADE_CUSTOMER_SHELL_R4 -->
<nav class="sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm" aria-label="Customer toolbar">
  <div class="flex items-center justify-between h-16 px-3 sm:px-5 gap-3">
    <div class="flex items-center gap-3 min-w-0">
      <button type="button" @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="Toggle sidebar" :aria-expanded="sidebarOpen.toString()" aria-controls="agrotrade-customer-sidebar"><i data-lucide="menu" class="w-5 h-5"></i></button>
      <a href="{{ route('dashboard') }}" class="flex items-center gap-2 min-w-0 text-gray-900 dark:text-white font-semibold" aria-label="Dashboard home">
        <img src="{{ asset('storage/app/public/'.$settings->logo) }}" class="h-8 w-auto max-w-24 object-contain" alt="" />
        <span class="hidden sm:inline truncate">{{ config('app.name', 'Agrotrade') }}</span>
      </a>
    </div>
    <div class="flex items-center gap-1 sm:gap-2 shrink-0">
      <div class="agrotrade-dashboard-language" aria-label="Translation language"><div class="gtranslate_wrapper_dashboard"></div></div>
      <div id="agrotrade-translation-loader" hidden aria-hidden="true" role="status" aria-label="Translating page"><span class="agrotrade-translation-spinner"></span><span class="sr-only">Translating</span></div>
      <button type="button" @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', darkMode)" class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="Toggle color theme"><i data-lucide="sun-moon" class="w-5 h-5"></i></button>
      @php
        $toolbarUnreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', 0)->count();
        $toolbarNotifications = \App\Models\Notification::where('user_id', Auth::id())->latest('created_at')->take(5)->get();
      @endphp
      <div class="relative" x-data="{ shown: false }" @keydown.escape.window="shown = false">
        <button type="button" @click="shown = !shown" :aria-expanded="shown.toString()" aria-label="Notifications" class="relative p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800"><i data-lucide="bell" class="w-5 h-5"></i>
          @if($toolbarUnreadCount > 0)<span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 text-xs flex items-center justify-center rounded-full bg-red-600 text-white">{{ $toolbarUnreadCount > 99 ? '99+' : $toolbarUnreadCount }}</span>@endif
        </button>
        <div x-show="shown" @click.outside="shown = false" x-cloak class="absolute right-0 mt-2 w-[min(22rem,calc(100vw-1rem))] max-h-[70vh] overflow-y-auto rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 shadow-xl z-50">
          <div class="flex items-center justify-between gap-2 px-4 py-3 border-b border-gray-200 dark:border-gray-700"><h2 class="font-semibold text-sm">Notifications</h2>
            @if($toolbarUnreadCount > 0)<form method="POST" action="{{ route('notifications.mark-all-read') }}">@csrf<button type="submit" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Mark all read</button></form>@endif
          </div>
          @forelse($toolbarNotifications as $notice)
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 {{ !$notice->is_read ? 'bg-blue-50 dark:bg-gray-700/50' : '' }}">
              <div class="flex gap-2 items-start justify-between"><div class="min-w-0"><p class="text-sm font-semibold break-words">{{ $notice->title }}</p><p class="text-xs text-gray-600 dark:text-gray-300 mt-1 break-words">{{ \Illuminate\Support\Str::limit($notice->message, 110) }}</p><p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $notice->created_at->diffForHumans() }}</p></div>
                @if(!$notice->is_read)<form method="POST" action="{{ route('notifications.mark-read') }}">@csrf<input type="hidden" name="notification_id" value="{{ $notice->id }}"><button type="submit" class="text-xs whitespace-nowrap text-blue-600 dark:text-blue-400 hover:underline" aria-label="Mark notification as read">Read</button></form>@endif
              </div>
            </div>
          @empty
            <p class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">No notifications</p>
          @endforelse
          <a href="{{ route('notifications') }}" class="block px-4 py-3 text-center text-sm text-blue-600 dark:text-blue-400 hover:underline">View all notifications</a>
        </div>
      </div>
      <div class="relative" x-data="{ shown: false }" @keydown.escape.window="shown = false">
        <button type="button" @click="shown = !shown" :aria-expanded="shown.toString()" aria-label="Account menu" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white"><span class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span><i data-lucide="chevron-down" class="w-4 h-4 hidden sm:block"></i></button>
        <div x-show="shown" @click.outside="shown = false" x-cloak class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-xl z-50 p-2">
          <p class="px-3 py-2 text-xs truncate text-gray-500 dark:text-gray-400">{{ Auth::user()->name }}</p>
          <a href="{{ route('profile') }}" class="block px-3 py-2 text-sm rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
          <a href="{{ route('support') }}" class="block px-3 py-2 text-sm rounded-lg text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">Support</a>
          <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Sign out</button></form>
        </div>
      </div>
    </div>
  </div>
</nav>


<!-- Sidebar Toggle Wrapper -->
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900" x-cloak>

  <!-- Sidebar -->
<aside id="agrotrade-customer-sidebar" x-cloak
  :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
  class="fixed z-50 md:z-40 top-16 left-0 w-72 h-[calc(100vh-4rem)] bg-white dark:bg-gray-900 shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0 overflow-y-auto">
    

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-6 text-sm pb-20" x-cloak>
        <!-- Overview Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Overview</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounthistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('accounthistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="receipt" class="w-5 h-5 mr-3"></i>
                        Account Statement
                    </a>
                </li>
            </ul>
        </div>

        <!-- Portfolio & Investments Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
                <span>Portfolio & Investments</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('mplans') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('user.plans.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="target" class="w-5 h-5 mr-3"></i>
                        Investment Plans
                    </a>
                </li>
                <li>
                    <a href="{{ route('myplans', 'All') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('myplans') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="pie-chart" class="w-5 h-5 mr-3"></i>
                        My Portfolio
                    </a>
                </li>
                <li>
                    <a href="{{ route('tradinghistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('tradinghistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="activity" class="w-5 h-5 mr-3"></i>
                        Performance History
                    </a>
                </li>
            </ul>
        </div>

        <!-- Trading & Markets Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>Trading & Markets</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('trade.index') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('trade.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="candlestick-chart" class="w-5 h-5 mr-3"></i>
                        Live Markets
                        <span class="ml-auto flex items-center px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full">
                            <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse mr-1.5"></div>
                            Live
                        </span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Real-time market trading
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('copy.dashboard') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('copy.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="users-2" class="w-5 h-5 mr-3"></i>
                        Copy Trading
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-full">Pro</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Follow expert traders
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.bots.index') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('user.bots.*') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="bot" class="w-5 h-5 mr-3"></i>
                        AI Trading Bots
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-full">AI</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Automated trading algorithms
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Trading Signals Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="radio" class="w-4 h-4"></i>
                <span>Market Intelligence</span>
            </div>
            
            <ul class="space-y-1">
                <!--@if(Auth::check() && Auth::user()->signals)-->
                <!--<li>-->
                <!--    <a href="{{ route('mysingals', 'All') }}"-->
                <!--       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('mysingals') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">-->
                <!--        <i data-lucide="signal" class="w-5 h-5 mr-3"></i>-->
                <!--        My Signals-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endif-->
                <li>
                    <a href="{{ route('signal') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('signals') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="zap" class="w-5 h-5 mr-3"></i>
                        Premium Signals
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full">Premium</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Expert trading insights
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Wallet & Funds Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="wallet" class="w-4 h-4"></i>
                <span>Wallet & Funds</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('deposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('deposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-3"></i>
                        Deposit Funds
                    </a>
                </li>
                <li>
                    <a href="{{ route('withdrawalsdeposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('withdrawalsdeposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="minus-circle" class="w-5 h-5 mr-3"></i>
                        Withdraw Funds
                    </a>
                </li>
                <li>
                    <a href="{{ route('transferview') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('transferview') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="arrow-left-right" class="w-5 h-5 mr-3"></i>
                        Internal Transfer
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('assetbalance') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('assetbalance') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="repeat" class="w-5 h-5 mr-3"></i>
                        Currency Exchange
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full">Swap</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Exchange between cryptocurrencies and fiat
                        </div>
                    </a>
                </li> --}}
            </ul>
        </div>

        <!-- Credit & Financing Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                <span>Credit & Financing</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('loan') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('loan') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="file-plus" class="w-5 h-5 mr-3"></i>
                        Apply for Credit
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full">Fast</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Apply for loans and credit facilities
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('veiwloan')}}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('veiwloan') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                        Credit History
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            View your loan applications and status
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Account Management Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="user-circle" class="w-4 h-4"></i>
                <span>Account Management</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('profile') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('profile') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="user" class="w-5 h-5 mr-3"></i>
                        Profile Settings
                    </a>
                </li>
                @if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes')
                <li x-data="{ kycOpen: false }" x-cloak>
                    @if(Auth::user()->account_verify === 'Verified')
                        <!-- Verified Status -->
                        <div class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800">
                            <i data-lucide="shield-check" class="w-5 h-5 mr-3 text-green-600 dark:text-green-400"></i>
                            <span class="font-medium text-green-700 dark:text-green-300">Account Verified</span>
                        </div>
                    @else
                        <!-- KYC Dropdown -->
                        <div class="relative">
                            <button @click="kycOpen = !kycOpen"
                                    class="flex items-center w-full px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 {{ request()->routeIs('account.verify') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                                <i data-lucide="shield-alert" class="w-5 h-5 mr-3"></i>
                                <span class="flex-1 text-left">Identity Verification</span>
                                <i data-lucide="chevron-down"
                                   :class="kycOpen ? 'rotate-180' : 'rotate-0'"
                                   class="w-4 h-4 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Content -->
                            <div x-show="kycOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="mt-2 ml-8 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm" x-cloak>

                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">
                                    Identity Verification
                                </h4>

                                @if(Auth::user()->account_verify === 'Under review')
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        Your verification is under review
                                    </p>
                                    <div class="flex items-center text-xs text-yellow-600 dark:text-yellow-400">
                                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                        <span>Processing</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                        Complete your identity verification to unlock full trading features
                                    </p>
                                    <a href="{{ route('account.verify') }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                                        <span>Verify Now</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </li>
                @endif
            </ul>
        </div>

        <!-- Growth & Referrals Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
                <span>Growth & Rewards</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('referuser') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('referuser') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                        Referral Program
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full">{{$settings->referral_commission}}%</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Earn {{$settings->referral_commission}}% commission on referrals
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Support & Help Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                <span>Support & Help</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('support') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('support') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <i data-lucide="headphones" class="w-5 h-5 mr-3"></i>
                        Support Center
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Get help from our support team
                        </div>
                    </a>
                </li>
            </ul>
        </div>

            <!-- Account Actions -->
            <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                <!-- Language Translator (Mobile/Sidebar) -->
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-3 py-2 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors duration-150">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

  <!-- Sidebar overlay for mobile -->
  <div
    x-show="sidebarOpen"
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-cloak>
  </div>

  <!-- Main content placeholder -->
  <div class="flex-1 min-w-0 ml-0 md:ml-72 p-4 pb-20 md:pb-4">
    <!-- Your main dashboard content goes here -->
    @yield('content')
  </div>
</div>





<!-- Script for Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  // Initialize Lucide icons
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
  });

  // Re-initialize icons when Alpine renders new content
  document.addEventListener('alpine:init', () => {
    Alpine.nextTick(() => {
      lucide.createIcons();
    });
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>



@yield('scripts')

@include('layouts.livechat')
</body>
</html>
