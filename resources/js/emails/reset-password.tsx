import {Html, Head, Body, Preview, Tailwind, Section, Heading, Text, Link} from "react-email";
import * as React from "react";
interface ResetPasswordTemplateProps {
    domain: string;
    token: string;
}

export default function ResetPassword({ domain, token }: ResetPasswordTemplateProps) {
    const resetLink = `${domain}/new-password?token=${token}`;

    return (
        <Html>
            <Head />
            <Preview>Сброс пароля</Preview>
            <Tailwind children={undefined}>
                <Body className="max-w-2xl mx-auto p-6 bg-[#131317]">
                    <Section className="text-center mb-8">
                        <Heading className="text-3xl text-white font-bold">MachineStore</Heading>
                        <Text className="text-xl text-white font-bold">Сброс пароля</Text>
                        <Text className="text-base text-white mb-4">
                            Мы получили запрос на сброс пароля для вашего аккаунта MachineStore. Для установки нового
                            пароля перейдите по ссылке ниже:
                        </Text>

                        <Section className="text-center mt-6">
                            <Link
                                href={resetLink}
                                className="inline-flex justify-center items-center rounded-full text-sm font-medium text-white !important bg-[#253ECE] px-6 py-3"
                            >
                                Сбросить пароль
                            </Link>
                        </Section>

                        <Text className="text-base text-white mt-6">
                            Ссылка действительна в течение 1 часа. Если вы не запрашивали сброс пароля, просто
                            проигнорируйте это письмо.
                        </Text>
                    </Section>

                    <Section className="text-center mt-8">
                        <Text className="text-gray-600 text-sm">
                            Если кнопка не работает, скопируйте и вставьте следующую ссылку в браузер:
                        </Text>
                        <Text className="text-[#5074d6] text-sm break-all mt-2">{resetLink}</Text>
                    </Section>

                    <Section className="text-center mt-8">
                        <Text className="text-gray-600">
                            Если у вас есть вопросы или вы столкнулись с трудностями, не стесняйтесь обращаться в
                            нашу службу поддержки по адресу{' '}
                            <Link href="mailto:machine-store-service.sup@mail.ru" className="text-[#5074d6] underline">
                                help@machinestore
                            </Link>
                        </Text>
                    </Section>
                </Body>
            </Tailwind>
        </Html>
    );
}
