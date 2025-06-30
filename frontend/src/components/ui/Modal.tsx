
import { Modal as FBModal } from "flowbite-react";
import { useEffect, useState } from "react";


export default function Modal({isOpen, header, body, footer, id, onClose}) {
  const [openModal, setOpenModal] = useState(false);

  useEffect(() => {
    setOpenModal(isOpen)
  }, [id, isOpen])

  const handleClose = () => {
    setOpenModal(false)
    onClose()
  }

  const customTHeme = { 
    // for changing modal style check interface CustomThemeFlowbite 
    content: { 
        base: "relative w-full p-4 md:h-auto " 
    }
  }

  return (
    <>
        <FBModal 
            dismissible 
            show={openModal} 
            onClose={handleClose} 
            position="center" 
            size="5xl" 
            theme={customTHeme}
        >
            {header && (<FBModal.Header className={"bg-secondary " + header.className }>{header.content}</FBModal.Header>)}
            {body && <FBModal.Body className={body.className}>{body.content}</FBModal.Body>}
            {footer && (<FBModal.Footer className={footer.className}>{footer.content}</FBModal.Footer>)}
        </FBModal>
    </>
  );
}
