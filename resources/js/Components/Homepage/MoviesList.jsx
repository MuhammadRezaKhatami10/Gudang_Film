const isMovies = (movies) => {
    return movies.map((data, i) => {
        return <div key={i} className="card w-full w-96 bg-base-100 shadow-xl">
            <figure>
                <img src="https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/jawapos/2019/03/melalui-poster-terbaru-karakter-di-avengers-endgame-terkuak_m_.jpg" 
                alt="Poster" />
            </figure>
            <div className="card-body">
                <h2 className="card-title">
                    {data.title}
                    <div className="badge badge-secondary">NEW</div>
                </h2>
                <p>{data.description}</p>
                <div className="card-actions justify-end">
                    <div className="badge badge-outline">{data.category}</div>
                    <div className="badge badge-outline">{data.production}</div>
                </div>
            </div>
        </div>
    })
}

const noMovies= () => {
    return(
        <div>Saat ini belum ada film yang tersedia</div>
    )
}

const MoviesList = ({ movies }) => {
    return !movies ? noMovies() : isMovies(movies)
}

export default MoviesList