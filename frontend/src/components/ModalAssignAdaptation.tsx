
import Modal from "../components/ui/Modal";
// import { Button } from "flowbite-react";
import ListResourceAssign from "../components/ui/ListResourceAssign";
import  Button  from "./ui/Button";

export default function ModalAssignAdaptation({user, showModal, group, onCloseModal }) {
    const handleSaveAdaptation = () => {}
    const resources = group?.resources ?? []

    console.log({group, resources})

    if (!group || !user) return null

    return (
        <Modal
            id={user?.id}
            isOpen={showModal} 
            header={{
                content: (
                    <>
                        <span>Assign adaptation to resources</span>
                        <span className="text-sm text-gray-500 flex flex-row w-full justify-between content-between mt-3">
                            <span>{group?.name}</span>
                            <span>{user?.name ?? ''}</span>
                        </span>
                    </>
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
                    <>
                        <ListResourceAssign resources={resources} userid={user?.id} handleChange={() => {}}/>
                    </>
                ),
                className: ''
            }}
            onClose={onCloseModal}
        />
    )
}