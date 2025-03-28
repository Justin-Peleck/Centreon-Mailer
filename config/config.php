<?php

/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright (c) 2023-2024 Oracle and/or its affiliates. All rights reserved.
 *
 * Oracle and Java are registered trademarks of Oracle and/or its affiliates.
 * Other names may be trademarks of their respective owners.
 *
 * The contents of this file are subject to the terms of either the GNU
 * General Public License Version 2 only ("GPL") or the Common
 * Development and Distribution License("CDDL") (collectively, the
 * "License"). You may not use this file except in compliance with the
 * License. You can obtain a copy of the License at
 * http://www.netbeans.org/cddl-gplv2.html
 * or nbbuild/licenses/CDDL-GPL-2-CP. See the License for the
 * specific language governing permissions and limitations under the
 * License.  When distributing the software, include this License Header
 * Notice in each file and include the License file at
 * nbbuild/licenses/CDDL-GPL-2-CP.  Oracle designates this
 * particular file as subject to the "Classpath" exception as provided
 * by Oracle in the GPL Version 2 section of the License file that
 * accompanied this code. If applicable, add the following below the
 * License Header, with the fields enclosed by brackets [] replaced by
 * your own identifying information:
 * "Portions Copyrighted [year] [name of copyright owner]"
 *
 * If you wish your version of this file to be governed by only the CDDL
 * or only the GPL Version 2, indicate your decision by adding
 * "[Contributor] elects to include this software in this distribution
 * under the [CDDL or GPL Version 2] license." If you do not indicate a
 * single choice of license, a recipient has the option to distribute
 * your version of this file under either the CDDL, the GPL Version 2 or
 * to extend the choice of license to its licensees as provided above.
 * However, if you add GPL Version 2 code and therefore, elected the GPL
 * Version 2 license, then the option applies only if the new code is
 * made subject to such option by the copyright holder.
 *
 * Contributor(s):
 *
 */



/**
 * Centreon Mailer Config
 * @author Justin N'GUESSAN <Justin Peleck Peniel>
 * @copyright (c) 2025, Justin N'GUESSAN
 * @version 1.0
 * @email : justin.nguessan@africanticgroup.com
 * @email : justinpeleck@gmail.com
 * @website https://africanticgroup.com
 */



class Config
{
    /**
     * Server Centreon Host Address
     * @return string
     */
    public static function server_address()
    {
        $server_address = "";
        return $server_address;
    }

    /**
     * Server SMTP Host Address
     * @return string
     */
    public static function server_host()
    {
        $smtp_host = "";
        return $smtp_host;
    }

    /**
     * Server SMTP Port
     * @default 25, 465 or 587 if Server secure is True
     * @return string
     */
    public static function server_port()
    {
        $smtp_port = "";
        return $smtp_port;
    }

    /**
     * Server SMTP Secure
     * @default True , False or 'PHPMailer::ENCRYPTION_STARTTLS'
     * @return string
     */
    public static function server_security(): string
    {
        $smtp_securtity = "";
        return $smtp_securtity;
    }

    /**
     * Server SMTP Email Address
     * @return string
     */
    public static function server_user(): string
    {
        $smtp_user = "";
        return $smtp_user;
    }

    /**
     * Server SMTP Email Password
     * @return string
     */
    public static function server_password(): string
    {
        $smtp_password = "";
        return $smtp_password;
    }

    /**
     * Mail recipient Param
     * @return array
     */
    public static function server_mail_config(): array
    {
        $server_config = [
            'form_email' => '',
            'form_name' => '',
            'reply_email' => '',
            'reply_name' => '',
        ];
        return $server_config;
    }


}