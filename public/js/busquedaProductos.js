document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("busqueda");
    const container = document.getElementById("productContainer");

    input.addEventListener("input", function () {
        const filtro = this.value.toLowerCase();
        const cards = container.querySelectorAll(".product-card");
        cards.forEach(card => {
            const nombre = card.querySelector(".card-title").textContent.toLowerCase();
            card.style.display = nombre.includes(filtro) ? "block" : "none";
        });
    });

    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const productId = button.getAttribute('data-productid');
        const form = deleteModal.querySelector('#deleteForm');
        form.action = `/productos/${productId}`;
    });
});