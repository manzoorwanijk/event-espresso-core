(this.webpackJsonproot=this.webpackJsonproot||[]).push([[8],{2674:function(e,t,a){"use strict";var l=a(0),n=a.n(l),s=a(4),c=a(15),r=a(13),i={placement:"top"};t.a=function(e){var t=e.datetime,a=Object(r.useRegistrationsLink)({datetime_id:t.dbId}),l=Object(s.__)("view ALL registrations for this date.");return n.a.createElement(c.RegistrationsLink,{href:a,tooltip:l,tooltipProps:i})}},2675:function(e,t,a){"use strict";var l=a(0),n=a.n(l),s=a(4),c=a(23),r=a(15),i=a(13);t.a=function(e){var t=e.entity,a=Object(i.useDatetimeMutator)(t.id).updateEntity,o=Object(i.useUpdateRelatedTickets)(t.id),u=Object(i.useTicketQuantityForCapacity)(),m=Object(l.useCallback)((function(e){var l=Object(c.parseInfinity)(e);if(l!==t.capacity){a({capacity:l});var n=u(l);o(n)}}),[t.capacity,a,u,o]);return n.a.createElement(r.InlineEditInfinity,{onChange:m,tooltip:Object(s.__)("edit capacity (registration limit)\u2026"),value:"".concat(t.capacity)})}},2676:function(e,t,a){},2680:function(e,t,a){"use strict";var l=a(3),n=a.n(l),s=a(9),c=a.n(s),r=a(0),i=a.n(r),o=a(15),u=a(617),m=function(e){return Object(u.b)("datetime",e)};t.a=function(e){var t=e.entity,a=c()(e,["entity"]),l=m(t);return i.a.createElement(o.EntityActionsMenu,n()({},a,{menuItems:l}))}},2681:function(e,t,a){"use strict";a.d(t,"a",(function(){return i}));var l=a(0),n=a.n(l),s=a(4),c=a(13),r=a(15),i=function(e){var t=e.className,a=e.entity,i=e.view,o=void 0===i?"card":i,u=Object(c.useDatetimeMutator)(a.id).updateEntity,m=Object(s.__)("edit title\u2026"),d=a.name||m,b="card"===o&&2,p=Object(l.useCallback)((function(e){e!==a.name&&u({name:e})}),[a.name,u]);return n.a.createElement(r.InlineEditText,{className:t,fitText:"card"===o,lineCount:b,onChange:p,tag:"table"===o?"div":"h4",tooltip:m,value:d})}},2684:function(e,t,a){"use strict";a.r(t);var l=a(0),n=a.n(l),s=a(4),c=a(15),r=a(13),i=a(3),o=a.n(i),u=a(22),m=a.n(u),d=a(24),b=Object(d.withFeature)("use_bulk_edit")((function(e){var t=Object(r.useVisibleDatetimeIds)(),a=m()(t,1)[0];return n.a.createElement(c.ActionCheckbox,o()({},e,{visibleEntityIds:a}))})),p=function(){return Object(l.useCallback)((function(e){var t=e.displayStartOrEndDate;return{cells:[{key:"stripe",type:"cell",className:"ee-date-list-col-hdr ee-entity-list-status-stripe ee-rspnsv-table-column-nano",value:""},{key:"checkbox",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-checkbox ee-rspnsv-table-column-micro",value:n.a.createElement("div",{className:"ee-rspnsv-table-hide-on-mobile"},n.a.createElement(b,null))},{key:"id",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-id ee-number-column ee-rspnsv-table-column-nano",value:Object(s.__)("ID")},{key:"name",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-name ee-rspnsv-table-column-huge",value:Object(s.__)("Name")},{key:"start",type:"cell",className:"ee-date-list-col-hdr ee-rspnsv-table-column-default",value:n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{className:"ee-rspnsv-table-long-label"},Object(s.__)("Start Date")),n.a.createElement("span",{className:"ee-rspnsv-table-short-label"},Object(s.__)("Start")))},{key:"end",type:"cell",className:"ee-date-list-col-hdr ee-rspnsv-table-column-default",value:n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{className:"ee-rspnsv-table-long-label"},Object(s.__)("End Date")),n.a.createElement("span",{className:"ee-rspnsv-table-short-label"},Object(s.__)("End")))},{key:"capacity",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-capacity ee-rspnsv-table-column-tiny ee-number-column",value:n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{className:"ee-rspnsv-table-long-label"},Object(s.__)("Capacity")),n.a.createElement("span",{className:"ee-rspnsv-table-short-label"},Object(s.__)("Cap")))},{key:"sold",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-sold ee-rspnsv-table-column-tiny ee-number-column",value:Object(s.__)("Sold")},{key:"registrations",type:"cell",className:"ee-date-list-col-hdr ee-date-list-col-registrations ee-rspnsv-table-column-smaller ee-centered-column",value:n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{className:"ee-rspnsv-table-long-label"},Object(s.__)("Reg list")),n.a.createElement("span",{className:"ee-rspnsv-table-short-label"},Object(s.__)("Regs")))},{key:"actions",type:"cell",className:"ee-date-list-col-hdr ee-actions-column ee-rspnsv-table-column-big ee-centered-column",value:n.a.createElement(n.a.Fragment,null,n.a.createElement("span",{className:"ee-rspnsv-table-long-label"},Object(s.__)("Actions")),n.a.createElement("span",{className:"ee-rspnsv-table-short-label"},Object(s.__)("Actions")))}].filter(Object(r.filterCellByStartOrEndDate)(t)),className:"ee-editor-date-list-items-header-row",key:"dates-list-header",primary:!0,type:"row"}}),[])},y=a(26),O=a(300),v=a.n(O),f=a(611),j=a.n(f),_=a(47),E=a(886),h=a(11),k=a(23),g=a(2674),N=a(2680),D=a(2675),w=a(2681),T=(a(2676),Object(c.addZebraStripesOnMobile)(["row","stripe","name","actions"])),C=function(){var e=Object(r.useDatetimes)(),t=Object(l.useMemo)((function(){return Object(h.idToEntityMap)(e)}),[e]);return Object(l.useCallback)((function(e){var a=e.entityId,l=e.filterState,s=null===t||void 0===t?void 0:t[a],c=l.displayStartOrEndDate,i=l.sortingEnabled,o=Object(E.getDatetimeBackgroundColorClassName)(s),u=s.dbId||Object(k.shortenGuid)(s.id),m=Object(E.datetimeStatus)(s),d={key:"capacity",type:"cell",className:"ee-date-list-cell ee-date-list-col-capacity ee-rspnsv-table-column-tiny ee-number-column ee-col-5",value:i?s.capacity:n.a.createElement(D.a,{entity:s})},p={key:"name",type:"cell",className:"ee-date-list-cell ee-date-list-col-name ee-col-name ee-rspnsv-table-column-bigger ee-rspnsv-table-hide-on-mobile",value:i?s.name:n.a.createElement(w.a,{className:"ee-entity-list-text ee-focus-priority-5",entity:s,view:"table"})},O=[{key:"stripe",type:"cell",className:"ee-date-list-cell ee-entity-list-status-stripe ".concat(o," ee-rspnsv-table-column-nano"),value:n.a.createElement("div",{className:"ee-rspnsv-table-show-on-mobile"},s.name)},{key:"checkbox",type:"cell",className:"ee-date-list-cell ee-date-list-col-checkbox ee-rspnsv-table-column-micro",value:n.a.createElement(b,{dbId:s.dbId,id:s.id})},{key:"id",type:"cell",className:"ee-date-list-cell ee-date-list-col-id ee-rspnsv-table-column-nano ee-number-column",value:u},p,{key:"start",type:"cell",className:"ee-date-list-cell ee-rspnsv-table-column-default",value:Object(y.format)(new Date(s.startDate),_.ENTITY_LIST_DATE_TIME_FORMAT)},{key:"end",type:"cell",className:"ee-date-list-cell ee-rspnsv-table-column-default",value:Object(y.format)(new Date(s.endDate),_.ENTITY_LIST_DATE_TIME_FORMAT)},d,{key:"sold",type:"cell",className:"ee-date-list-cell ee-date-list-col-sold ee-rspnsv-table-column-tiny ee-number-column",value:s.sold||0},{key:"registrations",type:"cell",className:"ee-date-list-cell ee-date-list-col-registrations ee-rspnsv-table-column-smaller ee-centered-column",value:i?"-":n.a.createElement(g.a,{datetime:s})},{key:"actions",type:"cell",className:"ee-date-list-cell ee-date-list-col-actions ee-actions-column ee-rspnsv-table-column-big",value:i?"-":n.a.createElement(N.a,{entity:s})}],f=v()(Object(r.filterCellByStartOrEndDate)(c));return{cells:j()(f,T)(O),className:"ee-editor-date-list-view-row ".concat(m),id:"ee-editor-date-list-view-row-".concat(s.id),key:"row-".concat(s.id),type:"row"}}),[t])},S=a(152),I=a(28),A=a(5),F=a.n(A),x=a(875),B=a.n(x),M=a(2671),L=a(1785),R=a(2672),P=a(66),G=a(97),J=a.n(G),U=a(153),V=a.n(U),Y=a(476),z=a(234),Q=function(){var e=V()(J.a.mark((function e(t){return J.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(z.yupToFinalFormErrors)(Z,t);case 2:return e.abrupt("return",e.sent);case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),Z=Y.object({name:Y.string().min(3,(function(){return Object(s.__)("Name must be at least three characters")}))});function q(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var l=Object.getOwnPropertySymbols(e);t&&(l=l.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),a.push.apply(a,l)}return a}function H(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?q(Object(a),!0).forEach((function(t){F()(e,t,a[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):q(Object(a)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))}))}return e}var K=Object(P.intervalsToOptions)(B()(["months","weeks","days","hours","minutes"],P.DATE_INTERVALS),!0),W=function(e){var t=e.onSubmit,a=Object(l.useCallback)((function(e,a){for(var l=arguments.length,n=new Array(l>2?l-2:0),s=2;s<l;s++)n[s-2]=arguments[s];return t.apply(void 0,[e,a].concat(n))}),[t]),n=Object(I.useMemoStringify)({className:"ee-form-item-pair"});return Object(l.useMemo)((function(){return H(H({},e),{},{onSubmit:a,validate:Q,layout:"horizontal",debugFields:["values","errors"],sections:[{name:"basics",icon:M.a,title:Object(s.__)("Basics"),fields:[{name:"name",label:Object(s.__)("Name"),fieldType:"text",min:3},{name:"description",label:Object(s.__)("Description"),fieldType:"rich-text-editor"}]},{name:"dates",icon:L.a,title:Object(s.__)("Dates"),fields:[{name:"shiftDates",label:Object(s.__)("Shift dates"),fieldType:"group",formControlProps:{className:"shift-dates"},subFields:[{name:"value",fieldType:"number",min:1},{name:"unit",fieldType:"select",options:K},{name:"type",fieldType:"select",options:[{label:"",value:""},{label:Object(s.__)("earlier"),value:"earlier"},{label:Object(s.__)("later"),value:"later"}]}]}]},{name:"details",icon:R.a,title:Object(s.__)("Details"),fields:[{name:"capacity",label:Object(s.__)("Capacity"),fieldType:"number",parseAsInfinity:!0,min:-1,formControlProps:n}]}]})}),[n,e,a])},X=function(e){var t=Object(d.useBulkEdit)(),a=t.getSelected,n=t.unSelectAll,s=Object(r.useDatetimes)(),c=Object(r.useBulkEditDatetimes)().updateEntities;return Object(l.useCallback)((function(t){e(),n();var l=Object(r.formToBulkUpdateInput)(t,s,a());c(l)}),[s,a,e,n,c])},$=function(e){var t=e.onClose,a=e.isOpen,l=X(t),r=W({onSubmit:l});return n.a.createElement(c.BulkEditDetails,{formConfig:r,isOpen:a,onClose:t,title:Object(s.__)("Bulk edit date details"),warning:Object(s.__)("any changes will be applied to ALL of the selected dates.")})},ee=function(e){var t=e.areTrashedDates,a=e.onClose,n=Object(d.useBulkEdit)(),s=n.getSelected,c=n.unSelectAll,i=Object(r.useBulkDeleteDatetimes)();return Object(l.useCallback)((function(){a(),c(),i(s(),t)}),[t,i,s,a,c])},te=function(e){var t=e.areTrashedDates,a=e.onClose,r=ee({areTrashedDates:t,onClose:a}),i=Object(c.useConfirmationDialog)({message:t?Object(s.__)("Are you sure you want to permanently delete these datetimes? This action can NOT be undone!"):Object(s.__)("Are you sure you want to trash these datetimes?"),title:t?Object(s.__)("Delete datetimes permanently"):Object(s.__)("Trash datetimes"),onConfirm:r,onCancel:a}),o=i.confirmationDialog,u=i.onOpen;return Object(l.useEffect)((function(){return u()}),[]),n.a.createElement(n.a.Fragment,null,o)},ae=Object(d.withFeature)("use_bulk_edit")((function(){var e=Object(l.useState)(""),t=m()(e,2),a=t[0],i=t[1],o=Object(S.useDisclosure)(),u=o.isOpen,d=o.onOpen,p=o.onClose,y=Object(r.useDatesListFilterState)().status===h.DatetimeStatus.trashedOnly,O=Object(I.useMemoStringify)([{value:"edit-details",label:Object(s.__)("edit datetime details")},{value:"delete",label:y?Object(s.__)("delete datetimes"):Object(s.__)("trash datetimes")}]),v=Object(l.useCallback)((function(e){i(e),d()}),[d]);return n.a.createElement(n.a.Fragment,null,n.a.createElement(c.BulkActions,{Checkbox:b,defaultAction:O[0].value,onApply:v,options:O}),u&&n.a.createElement(n.a.Fragment,null,"edit-details"===a&&n.a.createElement($,{isOpen:!0,onClose:p}),"delete"===a&&n.a.createElement(te,{areTrashedDates:y,onClose:p})))}));t.default=Object(d.withBulkEdit)((function(){var e=Object(r.useDatesListFilterState)(),t=Object(r.useFilteredDateIds)(),a=Object(r.useReorderDatetimes)(t).sortResponder,l=C(),i=p();return n.a.createElement(n.a.Fragment,null,n.a.createElement(ae,null),n.a.createElement(c.EntityTable,{bodyRowGenerator:l,domain:r.domain,entityIds:t,filterState:e,headerRowGenerator:i,listId:r.datesList,onSort:a,tableCaption:Object(s.__)("Event Dates"),tableId:"date-entities-table-view"}))}))}}]);
//# sourceMappingURL=dates-table-view.2b7e484a.chunk.js.map