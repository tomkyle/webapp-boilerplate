"use strict";(self.webpackChunktomkyle_webapp_boilerplate=self.webpackChunktomkyle_webapp_boilerplate||[]).push([[838],{503:function(t,e,s){s.r(e);var o=function(t,e){this.settings=Object.assign({toggleThemeSelector:t,rootElt:document.documentElement,transition:0,localStorageId:"theme"},e||{});var s=document.querySelectorAll(t);this.availableThemes=Array.from(s).map((t=>t.dataset.themeToggle)).filter(((t,e,s)=>s.indexOf(t)===e));const o=localStorage.getItem(this.settings.localStorageId);o&&!this.settings.rootElt.classList.contains(o)&&this.toggleTheme(o,!1),document.addEventListener("click",(t=>{if(t.target.matches(this.settings.toggleThemeSelector)){t.preventDefault();var e=t.target.dataset.themeToggle,s=this.toggleTheme(e,!0)?e:null;localStorage.setItem(this.settings.localStorageId,s)}}))};o.prototype={toggleTheme:function(t,e){return this.availableThemes.forEach((e=>{t!==e&&this.settings.rootElt.classList.remove(e)})),this.settings.transition&&e&&(this.settings.rootElt.classList.add("color-theme-in-transition"),window.setTimeout(function(){this.settings.rootElt.classList.remove("color-theme-in-transition")}.bind(this),this.settings.transition)),this.settings.rootElt.classList.toggle(t)}},e.default=o}}]);