(window.webpackJsonp=window.webpackJsonp||[]).push([[142],{364:function(e,t,r){"use strict";r.r(t);var n=r(3),a=r(2),o=r(149),c=r(121),s=r(117),i=r(16),l=r(20),w=r(25),g={},u="iso_a3",p=new c.a({declutter:!0,source:new s.a({format:new o.a,url:"https://ahocevar.com/geoserver/gwc/service/tms/1.0.0/ne:ne_10m_admin_0_countries@EPSG%3A900913@pbf/{z}/{x}/{-y}.pbf"}),style:function(e){var t=!!g[e.get(u)];return new i.c({stroke:new l.a({color:t?"rgba(200,20,20,0.8)":"gray",width:t?2:1}),fill:new w.a({color:t?"rgba(200,20,20,0.2)":"rgba(20,20,20,0.9)"})})}}),v=new n.a({layers:[p],target:"map",view:new a.a({center:[0,0],zoom:2})}),y=document.getElementById("type");v.on("click",function(e){var t=v.getFeaturesAtPixel(e.pixel);if(!t)return g={},void p.setStyle(p.getStyle());var r=t[0],n=r.get(u);"singleselect"===y.value&&(g={}),g[n]=r,p.setStyle(p.getStyle())})}},[[364,0]]]);
//# sourceMappingURL=vector-tile-selection.js.map