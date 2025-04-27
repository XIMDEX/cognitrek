
import Modal from "../components/ui/Modal";
import  Button  from "./ui/Button";
import { useEffect, useState } from "react";
import LibraryIcon from "./icons/LibraryIcon";
import { assingAdaptationResource, getAdaptationUserResource } from "../services/resourceService";

export default function ModalAssignAdaptation({user, showModal, group, resource, onCloseModal }) {
    const [selectedAdaptation, setSelectedAdaptation] = useState(null)
    const [adaptations, setAdaptations] = useState<{label: string, id: string}[]>([])
    const handleSaveAdaptation = () => {
        if (selectedAdaptation) {
            assingAdaptationResource(resource.id, user.id, selectedAdaptation)
                .then(() => {
                    onCloseModal()
                })
                .catch((err) => {
                    console.error(err)
                })
        }
    }

    const handleSelectedAdaptation = (value) => {
        setSelectedAdaptation(value)
    }

    useEffect(() => {
        if (!user || !resource) return
        getAdaptationUserResource(resource.id, user.id)
            .then((data) => {
                setAdaptations(data)
            })
            .catch((err) => {
                console.error(err)
            })
    }, [user, resource])

    // useEffect(() => {
    // }, [selectedAdaptation, onCloseModal, resource, user])

    if (!group || !user || !resource) return null

    return (
        <Modal
            id={user?.id}
            isOpen={showModal} 
            header={{
                content: (
                    <span>Assign adaptation to resource</span>
                ), 
                className: 'border-primary border-b-4 [&>h3]:grow mb-0 pb-2'
            }}
            footer={{
                content: (
                    <>
                        <Button size="lg" className="bg-primary rounded-xl"  onClick={handleSaveAdaptation}>Save</Button>
                        <Button size="lg" variant="secondary" className="rounded-xl" onClick={onCloseModal}>Cancel</Button>
                    </>
                ),
                className: 'justify-end bg-slate-100'
            }}
            body={{
                content: (
                    <div className="px-6 py-4">
                        <p className="text-gray-600 mb-4">
                            Select an adaptation to assign to <span className="font-semibold">{user.name}</span>.
                        </p>
                        <div className="flex flex-row gap-2 mb-5">
                            <LibraryIcon className="" />
                            <span>{resource.name}</span>
                        </div>
                        <form onSubmit={handleSaveAdaptation}>
                            <div className="mb-4">
                            <label htmlFor="adaptation" className="block text-sm font-medium text-gray-700 mb-2">
                                Adaptation
                            </label>
                            <select
                                id="adaptation"
                                value={selectedAdaptation ?? 0}
                                onChange={(e) => handleSelectedAdaptation(e.target.value)}
                                className="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="0">Original</option>
                                {adaptations.map((adaptation) => (
                                    <option key={adaptation.id} value={adaptation.id}>
                                        {adaptation.label}
                                    </option>
                                ))}
                            </select>
                            </div>
                        </form>
                    </div>
                ),
                className: ''
            }}
            onClose={onCloseModal}
        />
    )
}