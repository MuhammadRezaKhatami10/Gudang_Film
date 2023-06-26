import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import { Inertia } from '@inertiajs/inertia';


export default function EditMovies(props) {
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [category, setCategory] = useState('');
    const [production, setProduction] = useState('');
    const [isNotif, setIsNotif] = useState(false);

    const handleSubmit = () => {
        const data = {
            id: props.myMovies.id, title, description, category
        }
        Inertia.post('/movies/update', data)
        setTitle('')
        setDescription('')
        setCategory('')
    }

    return (
        <div className='min-h-screen bg-slate-50'>
            <Head title={props.title} />
            <Navbar user={props.auth.user} />
            <div className="card w-full w-96 bg-base-100 shadow-xl m-2">
                <div className='p-2 text-2xl'>EDIT KETERANGAN FILM</div>
                <div className="card-body">
                    <input type="text" placeholder="Judul" className="m-2 input input-bordered input-info w-full"
                        onChange={(title) => setTitle(title.target.value)} defaultValue={props.myMovies.title} />
                    <input type="text" placeholder="Deskripsi" className="m-2 input input-bordered input-info w-full"
                        onChange={(description) => setDescription(description.target.value)} defaultValue={props.myMovies.title} />
                    <input type="text" placeholder="Kategori" className="m-2 input input-bordered input-info w-full"
                        onChange={(category) => setCategory(category.target.value)} defaultValue={props.myMovies.category} />
                    <button className='btn btn-primary m-2' onClick={() => handleSubmit()}>UPDATE</button>
                </div>
            </div>
        </div>
    )
}