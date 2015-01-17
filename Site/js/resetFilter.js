function reset(code) {
        $('#groupesFilter').val('all');
        loadGroupesListFilter();
        $('#profsComposantesFilter').val('all');
        loadProfsListFilter();
        $('#profsFilter').val(code);
        $('#departementFilter').val('all');
        loadSallesListFilter();
        $('#materielFilter').val('all');
        loadMaterielsListFilter()
}