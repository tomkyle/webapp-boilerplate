"use strict";(self.webpackChunktomkyle_webapp_boilerplate=self.webpackChunktomkyle_webapp_boilerplate||[]).push([[468],{785:function(e,t,s){s.r(t);var a=function(e,t){this.settings=Object.assign({triggerSelector:e,alertSuccess:null},t||{}),document.addEventListener("click",(e=>{e.target.matches(this.settings.triggerSelector)&&(e.preventDefault(),this.deleteCaches().then(function(){this.settings.alertSuccess&&alert(this.settings.alertSuccess),window.location.reload()}.bind(this)))}))};a.prototype={deleteCaches:async function(e){try{const e=await window.caches.keys();await Promise.all(e.map((e=>caches.delete(e))))}catch(e){}}},t.default=a}}]);