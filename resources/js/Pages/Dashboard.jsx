import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Inertia } from '@inertiajs/inertia';
import { Link, Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import route from '/vendor/tightenco/ziggy/src/js';

export default function Dashboard(props) {
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [category, setCategory] = useState('');
    const [production, setProduction] = useState('');
    const [isNotif, setIsNotif] = useState(false);

    const handleSubmit = () => {
        const data = {
            title, description, category
        }
        Inertia.post('/movies', data)
        setIsNotif(true)
        setTitle('')
        setDescription('')
        setCategory('')
    }

    console.log('data: ', props)

    useEffect(() => {
        if (!props.myMovies) {
            Inertia.get('/movies')
        }
        console.log('propss ', props)
    }, [])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Film yang diupload</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="p-6 text-gray-900">
                        {isNotif && <div className="alert alert-success">
                            <svg xmlns="http://www.w3.org/2000/svg" className="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{props.flash.message}</span>
                        </div>
                        }
                        <input type="text" placeholder="Judul" className="m-2 input input-bordered input-info w-full"
                            onChange={(title) => setTitle(title.target.value)} value={title} />
                        <input type="text" placeholder="Deskripsi" className="m-2 input input-bordered input-info w-full"
                            onChange={(description) => setDescription(description.target.value)} value={description} />
                        <input type="text" placeholder="Kategori" className="m-2 input input-bordered input-info w-full"
                            onChange={(category) => setCategory(category.target.value)} value={category} />
                        <button className='btn btn-primary m-2' onClick={() => handleSubmit()}>SUBMIT</button>
                    </div>
                </div>
                <div className="p-4">
                    {props.myMovies && props.myMovies.length > 0 ? props.myMovies.map((movies, i) => {
                        return (
                            <div key={i} className="card w-full w-96 bg-base-100 shadow-xl m-2">
                                <div className="card-body">
                                    <h2 className="card-title">
                                        {movies.title}
                                        <div className="badge badge-secondary">NEW</div>
                                    </h2>
                                    <p>{movies.description}</p>
                                    <div className="card-actions justify-end">
                                        <div className="badge badge-inline">{movies.category}</div>
                                        <div className="badge badge-outline">
                                            <Link href={route('edit.movies')} method="get" data={{id: movies.id}} as="button">
                                                Edit
                                            </Link>
                                        </div>
                                        <div className="badge badge-outline">
                                            <Link href={route('delete.movies')} method="post" data={{ id: movies.id }} as="button">
                                                Delete
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )
                    }) : <p>Anda belum menambahkan film</p>}

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
