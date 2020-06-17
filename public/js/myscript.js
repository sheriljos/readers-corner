const reviews = document.getElementById("reviews");

if (reviews) {
    reviews.addEventListener('click', e => {
        if (e.target.className === "btn btn-danger") {
            //TODO: Render a proper component
            if (confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/reviews/delete/${id}`, {
                    method: 'DELETE'
                }).then(response => console.log(response))
                .catch(err => alert('an error occured'))
            }
        }
    });
}