import { useEffect, useState } from "react";
import { getGroups } from "../services/groupService";
import { GroupUsers } from "../interfaces/groups";
import CardGroup from "../components/ui/CardGroup";
import Card from "../components/ui/Card";
import Input from "../components/ui/Input";
import { User } from "../interfaces/user";
import ModalAssignAdaptation from "../components/ModalAssignAdaptation";
import { useNavigate } from "react-router-dom";


export default function Groups() {
    const navigate = useNavigate()

    const [groups, setGroups] = useState<GroupUsers[]>([]);
    const [loading, setLoading] = useState(true)
    const [selected, setSelected] = useState<GroupUsers|null>(null)
    const [showModal, setShowModal] = useState(false)
    const [user, setUser] = useState<User|null>(null)
    
    useEffect(() => {
        getGroups()
            .then((data) => {
                setGroups(data);
            })
            .catch((err) => {
                console.error(err);
            })
            .finally(() => setLoading(false))
    }, [])

    useEffect(() => {
        if (selected && user) {
            navigate('/user-group', { state: { group: selected, user } })
        }
    }, [selected, user, navigate])

    const handleSelected = id => {
        const group = groups.find(g => g.id == id)

        setSelected(group ?? null)
    }

    if (loading) {
        return (<div>Loading...</div>)
    }

    return (
        <div className="max-w-7xl mx-auto p-6">
            <div className="mb-6">
                <span className="text-gray-400" role="button" onClick={() => handleSelected(null)}>Groups</span>
                {selected && (
                    <span> / {selected.name}</span>
                )}
            </div>
            <div className="flex justify-between items-center mb-8">
                {!selected ? (
                    <>
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900">Groups</h1>
                            <p className="text-xl text-blue-600 mt-1">{groups.length ?? 0} groups</p>
                        </div>

                        <div className="relative w-80">
                            {/* <XSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" /> */}
                            <Input type="text" placeholder="Search for group" className="pl-10 bg-white" />
                        </div>
                    </>
                ) : (
                    <>
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900">{selected.name}</h1>
                            <p className="text-xl text-blue-600 mt-1">{selected.users.length ?? 0} students</p>
                        </div>

                        <div className="relative w-80">
                            {/* <XSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" /> */}
                            <Input type="text" placeholder="Search for students" className="pl-10 bg-white" />
                        </div>
                    </>
                )}
            </div>
    
            <div className="grid  md:grid-cols-2 lg:grid-cols-3 gap-6">
            {!selected && groups.map((group) => (
                <CardGroup group={group} key={group.id} onSelect={handleSelected} />
            ))}

            { selected && selected.users.map(user => (
                <Card 
                    key={user.id} 
                    title={user.name} 
                    category={user.email} 
                    id={user.id} 
                    onClick={() => {
                        console.log('click')
                        setUser(user) 
                        setShowModal(true)
                    }}
                />
            ))}
            </div>
            <ModalAssignAdaptation 
                user={user} 
                group={selected}
                resource={null}
                showModal={showModal}  
                onCloseModal={() => {
                    setUser(null)
                    setShowModal(false)
                }}
            />
        </div>
        
    )
}