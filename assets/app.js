document.querySelectorAll('input[name="q"]').forEach(input=>input.addEventListener('keydown',e=>{if(e.key==='Escape')input.value=''}));

const catalog=document.getElementById('catalogProducts');
const viewButtons=document.querySelectorAll('.view-toggle');
if(catalog&&viewButtons.length){
  const saved=localStorage.getItem('absharCatalogView');
  if(saved==='table') catalog.classList.add('table-view');
  viewButtons.forEach(btn=>{
    if((saved==='table'&&btn.dataset.view==='table')||(saved!=='table'&&btn.dataset.view==='grid')) btn.classList.add('active');
    else btn.classList.remove('active');
    btn.addEventListener('click',()=>{
      const table=btn.dataset.view==='table';
      catalog.classList.toggle('table-view',table);
      localStorage.setItem('absharCatalogView',table?'table':'grid');
      viewButtons.forEach(b=>b.classList.toggle('active',b===btn));
    });
  });
}

const compareChecks=[...document.querySelectorAll('.compare-product')];
if(compareChecks.length){
  const badge=[...document.querySelectorAll('.compare-badge')].pop();
  const refresh=()=>{
    const selected=compareChecks.filter(x=>x.checked);
    if(selected.length>4){selected[selected.length-1].checked=false;return refresh();}
    if(badge) badge.textContent=selected.length?`المقارنة: ${selected.length}/4 منتجات`:'يمكن تحديد منتجات للمقارنة';
  };
  compareChecks.forEach(x=>x.addEventListener('change',refresh));
  refresh();
}