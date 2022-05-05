function removeRow(id, path) {
  let check = confirm("Silmək istədiyinizə əminsiniz?");

  if(check) {
    window.location.assign(path+id);
  }
}