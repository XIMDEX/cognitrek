import { useEffect, useState } from "react"
import { StaticStars } from "./ui/StarRate"
import { getFeedbacksResource } from "../services/feedbackService"

export default function ResourceFeedbackCard({ resource }) {
    const [rating, setRating] = useState(0)
    const [feedbacks, setFeedbacks] = useState<{ score: number }[]>([])

    useEffect(() => {
      if (resource.id === undefined) return
      if (feedbacks.length > 0) return

      getFeedbacksResource(resource.id)
        .then((feedbacks) => {
          setFeedbacks(feedbacks)
        })
        .catch((error) => console.error(error))
    }, [resource, feedbacks.length])

    useEffect(() => {
      if(feedbacks.length === 0) return
      const total = feedbacks.reduce((acc, feedback) => acc + feedback.score, 0)
      setRating(total / feedbacks.length)
    }, [feedbacks.length, feedbacks])
  
    return (
      <div className="flex flex-col gap-4 rounded-lg border bg-white p-4 shadow-sm">
        <div className="flex gap-4">
          <div className="h-20 w-20 flex-shrink-0 rounded bg-gray-100">
          <div className="w-imageCard h-imageCard flex-none rounded-imageCard flex items-center justify-center bg-disabled-bg">
            <div className="flex flex-col items-center gap-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-6 h-6 text-primary-foreground">
                    <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"></path>
                    <path d="M9 10C10.1046 10 11 9.10457 11 8C11 6.89543 10.1046 6 9 6C7.89543 6 7 6.89543 7 8C7 9.10457 7.89543 10 9 10Z" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"></path>
                    <path d="M2.66998 18.9505L7.59998 15.6405C8.38998 15.1105 9.52998 15.1705 10.24 15.7805L10.57 16.0705C11.35 16.7405 12.61 16.7405 13.39 16.0705L17.55 12.5005C18.33 11.8305 19.59 11.8305 20.37 12.5005L22 13.9005" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"></path>
                </svg>
                <p className="text-xs text-primary-foreground">No image</p> </div></div>
          </div>
          <div className="flex flex-col justify-between">
            <div>
              <h3 className="font-medium">{resource.name}</h3>
              <p className="text-sm text-gray-500">{resource.type}</p>
            </div>
          </div>
        </div>
        <div>
          <StaticStars   rating={rating} feedbacks={[]} />
        </div>
      </div>
    )
  }
