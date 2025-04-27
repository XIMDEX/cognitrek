import { XCardResource } from "@ximdex/xui-react/dist";
// import PencilIcon from "../icons/PencilIcon";
// import TrashIcon from "../icons/TrashIcon";

export default function Card({title, category, id,  onClick}) {
    const handleClick = () => onClick(id)
    return (
        <div role="button" onClick={handleClick}>
            <XCardResource
                title={title}
                category={category}
            />
        </div>
    )
}