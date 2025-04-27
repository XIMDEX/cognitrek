import MarkMap from "../Markmap";

export default function VisorMarkmap({content}) {

    console.log(content)

    return (
        <MarkMap markmap={content} />
    )
}