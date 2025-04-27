import { Navigate, useLocation, useNavigate } from "react-router-dom";
import Image from "../components/ui/Image";
import Avatar from "../components/ui/Avatar";
import { useState } from "react";
import ModalAssignAdaptation from "../components/ModalAssignAdaptation";
import Card from "../components/ui/Card";

export default function UserGroup() {
    const navigate = useNavigate();
    const location = useLocation();
    const { user, group } = location.state || {};
    const [resource, setResource] = useState(null);
    const [showModal, setShowModal] = useState(false);

    if ((!user && group ) || (user && !group) || (!user && !group)) {
      return <Navigate to="/groups" />
    }
    return (
        <div className="h-full flex flex-col ">
            <div className="p-6">
                <div className="mb-6">
                    <span className="text-gray-400" role="button" onClick={() => navigate('/groups')}>Groups</span>
                    {group && (
                        <span> / {group.name}</span>
                    )}
                </div>
                <h1 className=" text-3xl font-bold">{group.name}</h1>
            </div>
            <div className="flex-1 flex-grow overflow-y-auto px-6 pb-5">
                <div className="grid gap-8 lg:grid-cols-3">
                    <div className="lg:col-span-2">
                        <h2 className="mb-4 text-lg font-medium text-blue-600">{user.name}</h2>
                        <div className="rounded-lg border bg-white p-6 shadow-sm">
                            <div className="mb-8 flex items-start gap-6">
                                <Avatar items={[]} size="xl" image={user.image} username={user.name} email={user?.email} />
                                <div className="grid flex-1 gap-2">
                                    <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <p className="text-sm text-gray-500">Name:</p>
                                        <p>{user.name}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Phone:</p>
                                        <p>{user?.phone ?? '-'}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Apellidos:</p>
                                        <p>{user.surname  ?? '-'}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Rol:</p>
                                        <p className="text-blue-600">{user.role ?? 'Student'}</p>
                                    </div>
                                    <div className="col-span-2">
                                        <p className="text-sm text-gray-500">Email:</p>
                                        <p>{user.email}</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 className="mb-4 text-lg font-medium text-blue-600">Teachers</h2>
                        <div className="space-y-4">
                            {[1, 2, 3].map((i) => (
                            <div key={i} className="rounded-lg border bg-white p-4 shadow-sm">
                                <div className="flex items-center gap-4">
                                <Image
                                    src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-k4nApJ3tpeYXPo2xXSB5tEn43Mepen.png"
                                    alt={`Professor ${i}`}
                                    width={48}
                                    height={48}
                                    className="rounded-lg"
                                />
                                <div>
                                    <p className="font-medium">Teacher Demo {i}</p>
                                    <p className="text-sm text-gray-500">Surname {i}</p>
                                </div>
                                </div>
                            </div>
                            ))}
                        </div>
                    </div>
                </div>

                <section className="mt-12">
                    <div className="mb-4 flex items-start flex-col ">
                        <h2 className="text-2xl font-bold">Resources Group</h2>
                        <span className="text-blue-600 my-4">{group.resources.length ?? 0} Resources</span>
                    </div>

                    {/* Resources Grid */}
                    <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    { group && group.resources.map(resource => (
                        <Card
                            key={resource.id} 
                            title={resource.name} 
                            category={resource.type} 
                            id={resource.id} 
                            onClick={() => {
                                setResource(resource) 
                                setShowModal(true)
                            }}
                        />
                    ))}
                    </div>

                    <div className="mt-8 text-center">
                    <button className="text-blue-600 hover:underline">See more</button>
                    </div>
                </section>
            </div>

            <ModalAssignAdaptation
                user={user} 
                group={group}
                resource={resource}
                showModal={showModal}  
                onCloseModal={() => {
                    setResource(null)
                    setShowModal(false)
                }}
            />
        </div>
    )
}


