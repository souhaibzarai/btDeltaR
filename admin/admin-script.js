function confirmDelete(id, table) {
  if (confirm("Are you sure you want to delete this record?")) {
    window.location.href = `delete.php?deleteId=${id}&t=${table}`;
  }
}
document.addEventListener("DOMContentLoaded", function() {
  const rowCountSelect = document.getElementById("rowCount");
  const prevButton = document.getElementById("prevButton");
  const nextButton = document.getElementById("nextButton");
  const tableRows = Array.from(document.querySelectorAll("#dataTable tbody tr"));
  let currentPage = 0;
  let rowsPerPage = parseInt(rowCountSelect.value);

  rowCountSelect.addEventListener("change", function() {
    rowsPerPage = parseInt(rowCountSelect.value);
    showPage(currentPage);
  });

  prevButton.addEventListener("click", () => showPage(currentPage - 1));

  nextButton.addEventListener("click", () => showPage(currentPage + 1));

  const searchInput = document.getElementById("searchInput");

  searchInput.addEventListener("keyup", function() {
    const filter = searchInput.value.toUpperCase();
    tableRows.forEach(row => {
      const rowText = row.textContent || row.innerText;
      row.style.display = rowText.toUpperCase().includes(filter) ? "" : "none";
    });
  });

  function showPage(page) {
    const startIndex = page * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const totalPages = Math.ceil(tableRows.length / rowsPerPage);

    currentPage = page;
    prevButton.disabled = currentPage === 0;
    nextButton.disabled = currentPage === totalPages - 1;

    tableRows.forEach((row, index) => {
      row.style.display = (index >= startIndex && index < endIndex) ? "" : "none";
    });
  }

  showPage(currentPage);
});
