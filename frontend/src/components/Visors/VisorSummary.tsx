export default function VisorSummary({content}) {

    return (
        <div className="flex flex-col gap-4 p-5">
            <h3 className="text-2xl">Summary</h3>
            <p>{content}</p>
        </div>
    )
}